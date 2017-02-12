<?php

class Aics_SenangpayValidationModuleFrontController extends ModuleFrontController
{
	public function postProcess(){
		$cart = $this->context->cart;
		$customer = new Customer($cart->id_customer);
		
		if (!Validate::isLoadedObject($customer))
			Tools::redirect('index.php?controller=order&step=1');
			
		$currency = $this->context->currency;
		$total = (float)$cart->getOrderTotal(true, Cart::BOTH);
		$secretkey = $this->module->secret;
		
		$status_id = $_REQUEST['status_id'];
		$order_id = $_REQUEST['order_id'];
		$msg = $_REQUEST['msg'];
		$transaction_id = $_REQUEST['transaction_id'];
		$hash = $_REQUEST['hash'];
		
		$hashed_string = md5($secretkey.urldecode($status_id).urldecode($order_id).urldecode($transaction_id).urldecode($msg));
		
		$pay_status = 8; // 2 success
		
		/*
		$vars = compact('status_id','order_id', 'msg','transaction_id','hash', 'hashed_string');
		echo'<pre>'.print_r($vars, true).'</pre>';
		exit; // testing
		*/ 
		
		if($status_id == '1'):
			if($hashed_string == urldecode($hash)):
				$pay_status = 2;
			else:
				$pay_status = 8;
			endif;
		else:
			$pay_status = 8;
		endif;
		
		$this->module->validateOrder($cart->id, $pay_status, $total, $this->module->displayName, 'transaction: '.$transaction_id, [], (int)$currency->id, false, $customer->secure_key);
		Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
	}
}