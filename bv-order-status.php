<?php
/**
 * The plugin bootstrap file
 *
 *
 * @wordpress-plugin
 * Plugin Name:       Order Status Control for WooCommerce
 * Plugin URI:
 * Description:       Auto Complete orders for virtual-downloadable products after successful payment or predefine status.
 * Version:           0.1
 * Author:            BrightPlugins
 * Author URI:        https://BrightPlugins.com
 * Text Domain:       bv-order-status
 * Domain Path:       /languages
 * Tested up to: 5.7.2
 * Requires at least: 5.5
 * WC requires at least: 4.9
 * WC tested up to: 5.4.1
 * Requires PHP: 7.2
 * @package           bv-order-status
 *
 * @link              http://BrightVessel.com
 * @since             1.0.0
 */

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

/**
 * Define the required plugin constants
 */
define( 'BVOS_VER', '0.1' );
define( 'BVOS_FILE', __FILE__ );
define( 'BVOS_BASE_FILE', plugin_basename( __FILE__ ) );

require __DIR__ . '/vendor/autoload.php';
use \BP_Order_Control\Bootstrap;

final class BP_Order_Status_Control {

    private function __construct() {
        register_activation_hook( __FILE__, array( $this, 'pluginActivation' ) );
        register_activation_hook( __FILE__, array( $this, 'pluginDeactivation' ) );
        add_action( 'woocommerce_loaded', [$this, 'initPlugin'], 90 );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function initPlugin() {
        new Bootstrap;
    }

    /**
     * Run Codes on Plugin activation
     *
     * @return void
     */
    public function pluginActivation() {
        $installed = get_option( 'bp_order_status_control_installed' );
        if ( !$installed ) {
            update_option( 'bp_order_status_control_installed', time() );
        }
    }
    /**
     * Run Codes on Plugin deactivation
     * @return void
     */
    public function pluginDeactivation() {

    }

    /**
     * Initializes a singleton instance
     *
     * @return $instance
     */
    public static function init() {
        /**
         * @var mixed
         */
        static $instance = false;
        if ( !$instance ) {
            $instance = new self();
        }
        return $instance;
    }
}
/**
 * Initializes the main plugin
 */
function BrightPluginsOrderControl() {
    return BP_Order_Status_Control::init();
}

// kick-off the plugin
add_action( 'plugin_loaded', 'BrightPluginsOrderControl' );
