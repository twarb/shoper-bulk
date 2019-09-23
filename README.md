# shoper-bulk

bulk extension for shoper sdk  
  
setBulkLimit() - set limit of bulk body (from 1 to 25),  
getBulk() - set bulk single body call method to GET,  
postBulk() - set bulk single body call method to POST,   
putBulk() - set bulk single body call method to PUT,  
deleteBulk() - set bulk single body call method to DELETE,  
  
addBulkBody([bulk array]) - add array to bulk body requst,  
getBulkBody() - get array of bulk body,  
clearBulkBody() - clear bulk body   
  
example:  
  
  $resource = new \App\Shoper\Resource\Product($client);  
  $bulk = $resource->postBulk()->addBulkBody(    
   ['id'=> num,  
   'body' => ['foo' => 'bar']  
   ]);    
  $bulkData = $resource->getBulkBody();  
  $result = $resource->post($bulkData);  
