<?php

if (!defined('ABSPATH')) {
    exit;
}

class KWM_Campaigns {

    private $whatsapp;

    public function __construct() {
        $this->whatsapp = new KWM_Whatsapp();
    }

    public function init() {
        add_action('admin_post_kwm_send_campaign', [$this, 'send_campaign']);
    }

    public function send_campaign() {

        if (!current_user_can('manage_options')) {
            return;
        }

        $message = sanitize_text_field($_POST['message'] ?? '');

        if (empty($message)) return;

        // Dummy numbers (for demo)
        $numbers = ['919999999999', '918888888888'];

        foreach ($numbers as $phone) {
            $this->whatsapp->send_message($phone, $message, 'campaign');
        }

        wp_redirect(admin_url('admin.php?page=kwm-whatsapp&sent=1'));
        exit;
    }
}