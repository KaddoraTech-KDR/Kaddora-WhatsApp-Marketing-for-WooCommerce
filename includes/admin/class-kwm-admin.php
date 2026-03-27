<?php
if(!defined("ABSPATH")) exit;

class KWM_Admin{
    // register_settings
    public function register_settings() {
        register_setting(
            'kwm_settings_group', // group name
            'kwm_settings' // option name
        );
    }

    // register_menu
    public function register_menu() {
        add_menu_page(
            __("WhatsApp", "kaddora-whatsapp-marketing"),
            __("WhatsApp", "kaddora-whatsapp-marketing"),
            'manage_options',
            'kwm-whatsapp',
            array($this, "whatsapp_dashboard"),
            'dashicons-whatsapp',
            30
        );

        add_submenu_page(
            'kwm-whatsapp',
            __('Settings', "kaddora-whatsapp-marketing"),
            __('Settings', "kaddora-whatsapp-marketing"),
            'manage_options',
            'kwm-settings',
            [$this, 'settings_page']
        );

        add_submenu_page(
            'kwm-whatsapp',
            __('Campaigns', 'kaddora-whatsapp-marketing'),
            __('Campaigns', 'kaddora-whatsapp-marketing'),
            'manage_options',
            'kwm-campaigns',
            [$this, 'campaigns_page']
        );
        
        add_submenu_page(
            'kwm-whatsapp',
            __('Logs', 'kaddora-whatsapp-marketing'),
            __('Logs', 'kaddora-whatsapp-marketing'),
            'manage_options',
            'kwm-logs',
            [$this, 'logs_page']
        );
        
        add_submenu_page(
            'kwm-whatsapp',
            __('Abandoned Cart', 'kaddora-whatsapp-marketing'),
            __('Abandoned Cart', 'kaddora-whatsapp-marketing'),
            'manage_options',
            'kwm-abandoned',
            [$this, 'abandoned_page']
        );
    }
    
    // campaigns page 
    public function campaigns_page() {
        include KWM_PLUGIN_DIR . 'admin/views/campaigns.php';
    }

    // logs_page
    public function logs_page() {
        include KWM_PLUGIN_DIR . 'admin/views/logs.php';
    }
    
    public function abandoned_page() {
        include KWM_PLUGIN_DIR . "admin/views/abandoned-cart.php";
    }

    // settings_page
    public function settings_page() {
        include KWM_PLUGIN_DIR . "admin/views/settings.php";
    }

    // whatsapp_dashboar
    public function whatsapp_dashboard() {
        include KWM_PLUGIN_DIR . "admin/views/dashboard.php";
    }

    // enqueue_assets
    public function enqueue_assets() {
        wp_enqueue_style(
            'kwm-admin',
            KWM_PLUGIN_URL . "assets/css/admin.css",
            [],
            KWM_VERSION
        );
    }
}