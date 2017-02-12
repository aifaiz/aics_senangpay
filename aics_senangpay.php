<?php

use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Aics_Senangpay extends PaymentModule{
	
	public $mkey;
	public $secret;
	public function __construct(){
		
		$this->name = 'aics_senangpay';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
        $this->author = 'AiFAiZ';
        //$this->controllers = array('payment', 'validation');
        //$this->is_eu_compatible = 1;
		$this->mkey = '123456789012345';
		$this->secret = '123-123';

        $this->currencies = true;
        $this->currencies_mode = 'checkbox';
		
		$this->bootstrap = true;
        parent::__construct();
		
		$this->displayName = $this->trans('Senangpay payment', array(), 'Modules.AicsSenangpay.Admin');
        $this->description = $this->trans('Accept payments for FPX and Credit Card.', array(), 'Modules.AicsSenangpay.Admin');
        $this->confirmUninstall = $this->trans('Are you sure to remove this module? you wond be able to accept FPX payment later', array(), 'Modules.AicsSenangpay.Admin');
		
		
	}
	
	public function install(){
		if (!parent::install() || !$this->registerHook('paymentReturn')  || !$this->registerHook('paymentOptions')) {
            return false;
        }
		return true;
	}
	
	public function uninstall(){
		return true;
	}
	
	public function hookPaymentOptions($params){
		if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }
		
		$detail = 'order_boldman_'.$this->context->cart->id;
		$amount = number_format($this->context->cart->getOrderTotal(true), 2, '.', '');
		$order_id = 'bm_cart_'.$this->context->cart->id;
		$name = $this->context->customer->firstname . ' ' . $this->context->customer->lastname;
		$email = $this->context->customer->email;
		$address = new Address(intval($params['cart']->id_address_delivery));
		$phone = isset($address->phone) && !empty($address->phone) ? $address->phone : $address->phone_mobile;
		
		$hashed_string = md5($secretkey.urldecode($detail).urldecode($amount).urldecode($order_id));
		
		$newOption = new PaymentOption();
		$newOption->setCallToActionText($this->trans('Pay by SenangPay', array(), 'Modules.AicsSenangpay.Shop'));
		$newOption->setAction($this->context->link->getModuleLink($this->name, 'payment', array(), true));
		$newOption->setAdditionalInformation($this->fetch('module:aics_senangpay/views/templates/hook/aics_senangpay.tpl'));
        
		$payment_options = [
            $newOption,
        ];

        return $payment_options;
	}
	
	/*
	public function hookPaymentReturn($params){
		$state = $params['order']->getCurrentState();
		return $this->fetch('module:aics_senangpay/views/templates/hook/payment_page.tpl');
	}
	*/
	
	public function checkCurrency($cart)
    {
        $currency_order = new Currency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);
        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }
}