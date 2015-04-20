<?php 
class ModelPaymentPaybrasT extends Model {
  	public function getMethod($address) {
		if ($this->config->get('paybrast_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('paybrast_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
			if (!$this->config->get('paybrast_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
      	} else {
			$status = FALSE;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'         => 'paybrast',
        		'title'      => $this->config->get('paybrast_nome'),
				'sort_order' => $this->config->get('paybrast_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>