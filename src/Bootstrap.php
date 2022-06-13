<?php

namespace BP_Order_Control;

class Bootstrap {

	/**
	 * @var mixed
	 */
	protected $pluginBase = BVOS_BASE_FILE;

	public function __construct() {

		// add_action( 'admin_init', [$this, 'dfwc_param_cehck'], 90 );
		Order::init();

		add_action( 'woocommerce_general_settings', [$this, 'addOrderControlSettings'], 50 );
		add_filter( "plugin_row_meta", [$this, 'pluginMetaLinks'], 20, 2 );
		add_filter( "plugin_action_links_$this->pluginBase", [$this, 'plugin_settings_link'] );
	}
	/**
	 * Add zSettings Link
	 * @param $links
	 */
	public function plugin_settings_link( $links ) {
		$row_meta = array(
			'settings' => '<a href="' . get_admin_url( null, 'admin.php?page=wc-settings&tab=general' ) . '">' . __( 'Settings', 'pre-orders-for-woocommerce' ) . '</a>',
		);

		return array_merge( $links, $row_meta );
	}
	/**
	 * Add links to plugin's description in plugins table
	 *
	 * @param  array   $links Initial list of links.
	 * @param  string  $file  Basename of current plugin.
	 * @return array
	 */
	public function pluginMetaLinks( $links, $file ) {
		if ( $file !== $this->pluginBase ) {
			return $links;
		}
		$support_link = '<a title="Click here to rate and review this plugin on WordPress.org" target="_blank" href="https://wordpress.org/support/plugin/order-status-control-for-woocommerce/reviews/?filter=5">' . __( ' Rate this plugin » ', 'bp-order-status' ) . '</a>';

		$links[] = $support_link;

		return $links;
	}
	/**
	 * @param    $settings
	 * @return
	 */
	function addOrderControlSettings( $settings ) {

		$updated_settings = array();

		foreach ( $settings as $section ) {

			// at the bottom of the General Options section
			if ( isset( $section['id'] ) && 'general_options' == $section['id'] &&
				isset( $section['type'] ) && 'sectionend' == $section['type'] ) {

				if ( is_plugin_active( 'bp-custom-order-status-for-woocommerce/main.php' ) ) {

					$cosm__title     = __( 'Check Options', 'bv-order-status' );
					$cosm_plugin_url = admin_url( 'admin.php?page=wcbv-order-status-setting' );

				} elseif ( file_exists( WP_PLUGIN_DIR . '/bp-custom-order-status-for-woocommerce/main.php' ) ) {

					$cosm__title     = __( 'Activate Now', 'bv-order-status' );
					$cosm_plugin_url = wp_nonce_url( 'plugins.php?action=activate&plugin=bp-custom-order-status-for-woocommerce/main.php&plugin_status=all&paged=1', 'activate-plugin_bp-custom-order-status-for-woocommerce/main.php' );

				} else {

					$cosm__title     = __( 'Install Now', 'bv-order-status' );
					$cosm_plugin_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=bp-custom-order-status-for-woocommerce' ), 'install-plugin_bp-custom-order-status-for-woocommerce' );

				}

				$updated_settings[] = array(
					'name'     => __( 'Order Status to Completed', 'bv-order-status' ),
					'desc_tip' => __( 'Set condition for autocomplete order status', 'bv-order-status' ),
					'id'       => 'wc_order_status_control',
					'type'     => 'select',
					'options'  => [
						'default'      => __( 'Default', 'bv-order-status' ),
						'only_virtual' => __( 'All Orders which content only Virtual Products', 'bv-order-status' ),
						'only_paid'    => __( 'All Orders which have Paid Sucessfully', 'bv-order-status' ),
						'all'          => __( 'All Orders', 'bv-order-status' ),
						//    ''             => __( 'Custom Rules (WIP)', 'bv-order-status' ),

					],

					'default'  => 'default',
					'desc'     => __( 'To know more about the status option read the <a href="https://brightplugins.com/docs/order-status-control-for-woocommerce-free/" target="_blank">documentation</a>.<br>
                    Do you need full control over your Order Status Management?<br>Try Bright Vessel\'s completely free Custom Order Status Manager for WooCommerce. <a href="' . $cosm_plugin_url . '">' . $cosm__title . '</a>', 'bv-order-status' ),
				);
			}

			$updated_settings[] = $section;
		}

		return $updated_settings;
	}

}
