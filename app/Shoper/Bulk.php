<?php
  
namespace App\Shoper;
use \DreamCommerce\ShopAppstoreLib\Resource;

class Bulk extends Resource
{  
  protected $name = 'bulk';
  protected $bulkBody = array();
  protected $bulkMethod = 'GET';
  protected $limit = 25;
  
  private function countBody()
  {
	return count($this->bulkBody);
  }  
  
  public function addBulkBody($array = array())
  {
    $id = count($this->bulkBody);  
    
    $this->bulkBody[$id] = [
      
      "id" => $array['id'],
      "path" => '/webapi/rest/'.$this->bulkResource,
      "method" => $this->bulkMethod,
      "body" => $array['body']
      
      ];
   if($id == $this->limit-1) return 'bulk body is full';
   
   return $this;

  }
  
  public function addBulkParams($params, $id = null)
  {
	if(!isset($id) $id = count($this->bulkBody) - 1; 
	
	if(!isset($params['limit'])) $params['limit'] = 10;
	if(!isset($params['page'])) $params['page'] = 1;
	if(!isset($params['filters'])) $params['filters'] = null;
	
	$this->bulkBody[$id] += [ 'params' => [
			'limit' => $params['limit'],
			'page' => $params['page'],
			'filters' => json_encode($params['filters'])
		]
	];
	
	return $this;
  }
  
  public function setBulkLimit($limit)
  {
	if($limit <= 25 && $limit > 0 && self::countBody == 0)
	{
		$this->limit = $limit;
		return true;
	}	
	elseif ($limit <= 25 && $limit > 0 && self::countBody != 0)
	{
		return 'bulk body must be empty to change limit!';
	}
	else
	{
		return false;
	}
  }
  
  public function getBulk()
  {
    $this->bulkMethod = 'GET';
    return $this;
  }
  
  public function postBulk()
  {
    $this->bulkMethod = 'POST';
    return $this;
  }
  
  public function putBulk()
  {
    $this->bulkMethod = 'PUT';
    return $this;
  }
  
  public function deleteBulk()
  {
    $this->bulkMethod = 'DELETE';
    return $this;
  }
  
  public function clearBulkBody(){
  
    $this->bulkBody = [];
    
  }
  
  public function getBulkBody(){
    
   return $this->bulkBody;
    
  }
}  