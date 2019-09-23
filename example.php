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

$resource = new \App\Shoper\Resource\Product($client);

try{
	
	$random = time();
	for($i = 0; $i < 25; $i++)
	{
		$code = $random + $i;
		$bulk = $resource->postBulk()->addBulkBody([
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
