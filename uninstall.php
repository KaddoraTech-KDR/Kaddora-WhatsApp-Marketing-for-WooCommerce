<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// delete settings
delete_option('kwm_settings');

// optional: delete logs table
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}kwm_logs");