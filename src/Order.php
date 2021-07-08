<?php

namespace BP_Order_Control;

class Order {

    public function __construct() {

        add_action( 'woocommerce_payment_complete_order_status', [$this, 'isVirtualMarkasComplete'], 10, 3 );
        // add_action( 'admin_init', [$this, 'dfwc_param_cehck'], 90 );
    }

    /**
     * check if the order is have virtual products then mark is as completed
     *
     * @param $orderId
     */
    public function isVirtualMarkasComplete( $status, $orderId, $order ) {

        $virtualProducts     = false;
        $onlyVirtualProducts = true;
        // check each products
        foreach ( $order->get_items() as $item_id => $item ) {

            $bvProduct = $item->get_product();
            if ( $bvProduct->get_virtual() ) {
                $virtualProducts = true;
            }
            if ( !$bvProduct->get_virtual() ) {
                $onlyVirtualProducts = false;
            }

        }

        if ( $virtualProducts && $onlyVirtualProducts ) {
            return 'wc-completed';
        }
        return $status;
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