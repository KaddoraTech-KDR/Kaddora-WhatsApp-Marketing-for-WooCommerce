<?php
if(!defined("ABSPATH")) exit;

class KWM_Installer{
    public static function install(){
        global $wpdb;

        $table = $wpdb->prefix . "kwm_logs";
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table(
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            phone VARCHAR(20),
            message TEXT,
            status VARCHAR(20),
            type VARCHAR(20),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate;";

        require_once ABSPATH . "wp-admin/includes/upgrade.php";
        dbDelta($sql);

        // default settings
        add_option('kwm_settings', [
            'api_key' => '',
            'phone_number' => '',
        ]);
    }
}