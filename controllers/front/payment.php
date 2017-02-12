<?php

class Aics_SenangpayPaymentModuleFrontController extends ModuleFrontController{
	public function initContent(){
		parent::initContent();
		
		$cart = $this->context->cart;
		if (!$this->module->checkCurrency($cart))
			Tools::redirect('index.php?controller=order');

		$total = sprintf(
			$this->getTranslator()->trans('%1$s (tax incl.)', array(), 'Modules.AicsSenangpay.Shop'),
			Tools::displayPrice($cart->getOrderTotal(true, Cart::BOTH))
		);
		
		
		
		$mkey = $this->module->mkey;
		$secretkey = $this->module->secret;
		$detail = 'order_boldman_'.$this->context->cart->id;
		$amount = number_format($this->context->cart->getOrderTotal(true), 2, '.', '');
		$order_id = 'bm_cart_'.$this->context->cart->id;
		$name = $this->context->customer->firstname . ' ' . $this->context->customer->lastname;
		$email = $this->context->customer->email;
		$address = new Address(intval($this->context->cart->id_address_delivery));
		
		$phone = isset($address->phone) && !empty($address->phone) ? $address->phone : $address->phone_mobile;
		$hash = md5($secretkey.urldecode($detail).urldecode($amount).urldecode($order_id));
		
		$vars = compact('detail','amount', 'order_id', 'name','email','phone','hash','mkey');

		$this->context->smarty->assign($vars);
		
		
		$this->setTemplate('module:aics_senangpay/views/templates/front/payment_page.tpl');
	}
}