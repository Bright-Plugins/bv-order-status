<?php

namespace BP_Order_Control;

class Bootstrap {

    public function __construct() {

        // add_action( 'admin_init', [$this, 'dfwc_param_cehck'], 90 );
        Order::init();
    }

}
