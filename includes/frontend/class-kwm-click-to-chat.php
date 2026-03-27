<?php
if(!defined("ABSPATH")) exit;

class KWM_Click_To_Chat {
    public function get_whatsapp_url() {
        $settings = get_option('kwm_settings');
        $phone = $settings['phone_number'];

        if(empty($phone)) {
            return '#';
        }

        $message = urldecode("Hello, I need help");

        return "https://wa.me/{$phone}?text={$message}";
    }
}