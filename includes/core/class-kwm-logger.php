<?php
if(!defined("ABSPATH")) exit;

class KWM_Logger {
    public static function log($phone, $message, $type = 'general', $status = 'sent') {
        global $wpdb;
    
        $table = $wpdb->prefix . 'kwm_logs';
    
        $wpdb->insert($table, [
            'phone' => $phone,
            'message' => $message,
            'type' => $type,
            'status' => $status,
            'created_at' => current_time('mysql')
        ]);
    }
}