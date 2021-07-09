<?php

namespace BP_Order_Control;

class Bootstrap {

    public function __construct() {

        // add_action( 'admin_init', [$this, 'dfwc_param_cehck'], 90 );
        Order::init();

        add_action( 'woocommerce_general_settings', [$this, 'addOrderControlSettings'], 50 );
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
                    'desc'     => __( 'To know more about the status option read the <a href="https: //brightplugins.com/docs/order-status-control-for-woocommerce-free/" target="_blank">documantatiom</a>.', 'bv-order-status' ),
                );
            }

            $updated_settings[] = $section;
        }

        return $updated_settings;
    }

}
