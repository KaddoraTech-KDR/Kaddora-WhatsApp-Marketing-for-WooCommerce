<?php
if(!defined("ABSPATH")) exit;

class KWM_Webhook{
    // register_routes
    public function register_routes() {
        register_rest_route(
            'kwm/v1', 
            '/webhook',
            [
                'methods' => 'GET',
                'callback' => [$this, 'handle_webhook'],
                'permission_callback' => '__return_true'
            ]
        );
    }

    // handle_webhook
    public function handle_webhook($request) {

        $data = $request->get_json_params();

        if (WP_DEBUG) {
            error_log('[KWM Webhook] ' . print_r($data, true));
        }

        return [
            'status' => 'success',
            'message' => 'Webhook received'
        ];
    }
}