(function ($) {
    'use strict';

    $(document).ready(function () {
        /*jQuery firing on add to cart button click*/
        jQuery('.ajax_add_to_cart').click(function () {
            /*Product meta data being sent; this is where you'd do your 
            document.getElementsByName or .getElementById*/
            
            var product_meta_data = 'product-meta-data',
                product_id = this.getAttribute('data-product_id');
            
            /*Ajax request URL being stored*/
            jQuery.ajax({
                url: deposits_params.ajax_url,
                type: "POST",
                data: {
                    //action name (must be consistent with your php callback)
                    action: 'deposit_pro_cart_btn',
                    product_id: product_id,
                    nonce: deposits_params.ajax_nonce
                },
            async : false,
            success: function (data) {
               
            }
            });
        })

    });


})(jQuery);

// Other code using $ as an alias to the other library