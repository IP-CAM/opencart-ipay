<?php 
class ModelPaymentiPay extends Model {
  	public function getMethod($address, $total) { 
		$this->load->language('payment/ipay');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('paystation_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
		if ($this->config->get('ipay_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('ipay_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}	
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'       => 'ipay',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('ipay_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>
