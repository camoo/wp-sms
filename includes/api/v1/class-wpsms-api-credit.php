<?php

namespace CAMOO_SMS\Api\V1;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
use CAMOO_SMS\Option;

/**
 * @category   class
 * @package    CAMOO_SMS_Api
 * @version    1.0
 */
class Credit extends \CAMOO_SMS\RestApi
{

    public function __construct()
    {
        // Register routes
        add_action('rest_api_init', array( $this, 'register_routes' ));

        parent::__construct();
    }

    /**
     * Register routes
     */
    public function register_routes()
    {

        // SMS Newsletter
        register_rest_route($this->namespace . '/v1', '/credit', array(
            array(
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => array( $this, 'credit_callback' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
            )
        ));
    }

    /**
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     */
    public function credit_callback(\WP_REST_Request $request)
    {
        $output = array(
            'credit' => Option::getOptions('wp_camoo_sms_gateway_credit'),
        );

        return new \WP_REST_Response($output);
    }

    /**
     * Check user permission
     *
     * @param $request
     *
     * @return bool
     */
    public function get_item_permissions_check($request)
    {
        return current_user_can('wpcamoosms_setting');
    }
}

new Credit();
