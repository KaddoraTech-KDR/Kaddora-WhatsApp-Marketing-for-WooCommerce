<?php
if(!defined("ABSPATH")) exit;

class KWM_Public{
    
    private $chat;

    public function __construct() {
        $this->chat = new KWM_Click_To_Chat();
    }

    // register_shortcodes
    public function register_shortcodes(){
        add_shortcode('kwm_shortcode', array($this, "render_shortcode"));
    }

    // render_shortcode
    public function render_shortcode() {
        $url = $this->chat->get_whatsapp_url();
        return '<a href="' . esc_url($url) . '" target="_blank">Chat on WhatsApp</a>';
    }

    // render_floating_button
    public function render_floating_button() {
        $url = $this->chat->get_whatsapp_url();

        if ($url === '#') return;

        echo '<a href="' . esc_url($url) . '" target="_blank" class="kwm-float-btn">💬</a>';
    }

    // enqueue_assets
    public function enqueue_assets(){
        wp_enqueue_style(
            'kwm-public',
            KWM_PLUGIN_URL . "assets/css/public.css",
            [],
            KWM_VERSION
        );
    }
}