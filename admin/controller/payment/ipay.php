<?php 
class ControllerPaymentiPay extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/ipay');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ipay', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');
		
		$this->data['entry_id'] = $this->language->get('entry_id');
		$this->data['entry_gateway'] = $this->language->get('entry_gateway');
		//$this->data['entry_signature'] = $this->language->get('entry_signature');
		$this->data['entry_test'] = $this->language->get('entry_test');
		//$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['paid_order_status'] = $this->language->get('paid_order_status');
        $this->data['cancelled_order_status'] = $this->language->get('cancelled_order_status');
        $this->data['pending_order_status'] = $this->language->get('pending_order_status');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['id'])) {
			$this->data['error_id'] = $this->error['id'];
		} else {
			$this->data['error_id'] = '';
		}
		
 		if (isset($this->error['gateway'])) {
			$this->data['error_gateway'] = $this->error['gateway'];
		} else {
			$this->data['error_gateway'] = '';
		}
		/*
 		if (isset($this->error['signature'])) {
			$this->data['error_signature'] = $this->error['signature'];
		} else {
			$this->data['error_signature'] = '';
		}
		*/
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/ipay', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/ipay', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ipay_id'])) {
			$this->data['ipay_id'] = $this->request->post['ipay_id'];
		} else {
			$this->data['ipay_id'] = $this->config->get('ipay_id');
		}
		
		if (isset($this->request->post['ipay_gateway'])) {
			$this->data['ipay_gateway'] = $this->request->post['ipay_gateway'];
		} else {
			$this->data['ipay_gateway'] = $this->config->get('ipay_gateway');
		}
		/*		
		if (isset($this->request->post['ipay_signature'])) {
			$this->data['ipay_signature'] = $this->request->post['ipay_signature'];
		} else {
			$this->data['ipay_signature'] = $this->config->get('ipay_signature');
		}
		*/
		if (isset($this->request->post['ipay_test'])) {
			$this->data['ipay_test'] = $this->request->post['ipay_test'];
		} else {
			$this->data['ipay_test'] = $this->config->get('ipay_test');
		}
		
		if (isset($this->request->post['ipay_method'])) {
			$this->data['ipay_transaction'] = $this->request->post['ipay_transaction'];
		} else {
			$this->data['ipay_transaction'] = $this->config->get('ipay_transaction');
		}
		
		if (isset($this->request->post['ipay_total'])) {
			$this->data['ipay_total'] = $this->request->post['ipay_total'];
		} else {
			$this->data['ipay_total'] = $this->config->get('ipay_total'); 
		} 
				
		if (isset($this->request->post['ipay_order_status_id'])) {
			$this->data['ipay_order_status_id'] = $this->request->post['ipay_order_status_id'];
		} else {
			$this->data['ipay_order_status_id'] = $this->config->get('ipay_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['ipay_geo_zone_id'])) {
			$this->data['ipay_geo_zone_id'] = $this->request->post['ipay_geo_zone_id'];
		} else {
			$this->data['ipay_geo_zone_id'] = $this->config->get('ipay_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['ipay_status'])) {
			$this->data['ipay_status'] = $this->request->post['ipay_status'];
		} else {
			$this->data['ipay_status'] = $this->config->get('ipay_status');
		}
		
		if (isset($this->request->post['ipay_sort_order'])) {
			$this->data['ipay_sort_order'] = $this->request->post['ipay_sort_order'];
		} else {
			$this->data['ipay_sort_order'] = $this->config->get('ipay_sort_order');
		}
		
		
		if (isset($this->request->post['paid_order_status'])) {
			$this->data['paid_order_status'] = $this->request->post['paid_order_status'];
		} else {
			$this->data['paid_order_status'] = $this->config->get('paid_order_status');
		}
		
		
		if (isset($this->request->post['cancelled_order_status'])) {
			$this->data['cancelled_order_status'] = $this->request->post['cancelled_order_status'];
		} else {
			$this->data['cancelled_order_status'] = $this->config->get('cancelled_order_status');
		}
		
		
		if (isset($this->request->post['pending_order_status'])) {
			$this->data['pending_order_status'] = $this->request->post['pending_order_status'];
		} else {
			$this->data['pending_order_status'] = $this->config->get('pending_order_status');
		}
		
		

		$this->template = 'payment/ipay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/ipay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['ipay_id']) {
			$this->error['id'] = $this->language->get('error_id');
		}

		if (!$this->request->post['ipay_gateway']) {
			$this->error['gateway'] = $this->language->get('error_gateway');
		}
		/*
		if (!$this->request->post['ipay_signature']) {
			$this->error['signature'] = $this->language->get('error_signature');
		}
		*/
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
