<?php

require 'vendor/autoload.php';

try{
	\DreamCommerce\ShopAppstoreLib\Http::setRetryLimit(2);
	
	$client = \DreamCommerce\ShopAppstoreLib\Client::factory(
	\DreamCommerce\ShopAppstoreLib\Client::ADAPTER_BASIC_AUTH,
		array(
			'entrypoint'=> 'shop-addres',
			'username'=> 'admin',
			'password'=> 'pass'
			)
	);
				
	$client->authenticate(true);
	
} catch(\DreamCommerce\ShopAppstoreLib\Exception\Exception $ex) {
	die($ex->getMessage());
}

$resource = new \App\Shoper\Resource\ProductImage($client);

try{
	
	$random = time();
	for($i = 0; $i < 25; $i++)
	{
		$code = $random + $i;
		$resource->postBulk()->addBulkBody([
			'id' => $i,
			'body' =>[	
				'category_id' => 30793,
				'translations' => [
					'pl_PL' => [
						'name' => 'Bulk product '.$i,
						'active' => true
					]
				],
				'stock' => [
					'price' => 10,
					'active' => 1,
					'stock' => 10
				],
				'tax_id' => 1,
				'code' => 'bulk-'.($code),
				'unit_id' => 1
			]
		]);
	}
	$bulkData 	= $resource->getBulkBody();
	
	$result 	= $resource->post($bulkData);
	
	var_dump($result);
	
} catch(\DreamCommerce\ShopAppstoreLib\Exception\Exception $ex) {
	die($ex->getMessage());
}

echo '<hr>';

try{
	
	$random = time();
	
		$resource->getBulk()->addBulkBody([
			'id' => 1,
			'body' => null
		])->addBulkParams([ 'page' => 1, 'limit' => 50,
		'filters' => [
			'product_id' => 29368
		]]);
	
	$bulkData = $resource->getBulkBody();
		
	$result = $resource->post($bulkData);
	
	foreach($result['items'][0]["body"]["list"] as $v)
	{
		echo 
		'<hr>product_id: '.$v['product_id'].' <br>
		img name: '.$v['name'] .'<br>
		img unic_name: '.$v['unic_name'] .'<br>
		img hidden: '.$v['hidden'].'<br>
		url to img: <a href="https://shop-addres.com/userdata/gfx/'.$v['unic_name'].'.jpg">KLIK</a>';
	}
	
} catch(\DreamCommerce\ShopAppstoreLib\Exception\Exception $ex) {
	die($ex->getMessage());
}