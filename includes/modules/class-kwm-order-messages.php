<?php

if (!defined('ABSPATH')) {
    exit;
}

class KWM_Order_Messages {

    private $whatsapp;

    public function __construct() {
        $this->whatsapp = new KWM_WhatsApp();
    }

    public function init() {
        add_action('woocommerce_order_status_completed', [$this, 'order_completed']);
    }

    public function order_completed($order_id) {

        $order = wc_get_order($order_id);

        if (!$order) return;

        $phone = $order->get_billing_phone();
        $name  = $order->get_billing_first_name();

        if (!$phone) return;

        $message = "Hi {$name}, your order #{$order_id} has been delivered successfully.";

        $this->whatsapp->send_message($phone, $message);
    }
}