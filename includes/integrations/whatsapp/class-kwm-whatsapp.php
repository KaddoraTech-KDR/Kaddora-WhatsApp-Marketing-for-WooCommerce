<?php
if(!defined("ABSPATH")) exit;

class KWM_Whatsapp{
    // send message
    public function send_message($phone, $message, $type = 'general') {

        $phone = preg_replace('/[^0-9]/', '', $phone);
    
        // simulate sending
        $status = 'sent';
    
        // SAVE TO DATABASE (IMPORTANT)
        KWM_Logger::log($phone, $message, $type, $status);
    
        // optional debug
        if (WP_DEBUG) {
            error_log("[KWM WhatsApp] Sent to {$phone}");
        }
    
        return true;
    }

    // log
    private function log($message) {
        if(WP_DEBUG) {
            error_log('[KWM Whatsapp]' . $message);
        }
    }
}