<?php
if(!defined("ABSPATH")) exit;

class KWM_Abandoned_Cart{
    // init
    public function init() {
        add_action('wp_login', array($this, "track_user"));
    }

    // track_user
    public function track_user($user_login) {
        if (WP_DEBUG) {
            error_log('[KWM] User logged in for cart tracking: ' . $user_login);
        }
    }
} 