<?php
if(!defined("ABSPATH")) exit;

class KWM_WooCommerce {
    private $whatsapp;

    public function __construct() {
        $this->whatsapp = new KWM_Whatsapp();
    }

    public function init() {
        add_action('woocommerce_thankyou', array($this, "send_order_message"), 10, 1);
        // add_action('woocommerce_order_status_processing', array($this, "send_order_message"), 10, 1);
    }

    // send_order_message
    public function send_order_message($order_id) {
        if(!$order_id) {
            return;
        }

        $order = wc_get_order($order_id);

        if(!$order) return;

        $phone = $order->get_billing_phone();
        $name = $order->get_billing_first_name();

        if(empty($phone)) return;

        $message = "Hi {$name}, your order #{$order_id} has been received. Thank you!";

        $this->whatsapp->send_message($phone, $message);
    }
}