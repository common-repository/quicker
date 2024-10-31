<?php
    $features = array(
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-cart"></span>',
            'desc'   => esc_html__('One-Click Checkout can help you a simple button and the purchase will be immediately completed','quicker'),
            'title'  => esc_html__('1 Click Checkout','quicker')
        ),
        array(
            'icon'  => '<span class="fr-icon dashicons dashicons-image-filter"></span>',
            'desc'  => esc_html__('Checkout fields helps your Checkout page, blended with a simple and user-friendly interface','quicker'),
            'title' => esc_html__('Checkout Filed Editor','quicker')
        ),
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-buddicons-groups"></span>',
            'desc'  => esc_html__('Apply dynamic extra fees at checkout based on your customer’s choices, making your pricing strategies more flexible and transparent','quicker'),
            'title' => esc_html__('Extra Fees in Checkout','quicker')
        ),
        array(
            'icon' => '<span class="fr-icon dashicons dashicons-admin-page"></span>',
            'desc'  => esc_html__('Create a beautiful sliding cart for your WooCommerce store.Customer can shop smoothly with a sidebar cart','quicker'),
            'title' => esc_html__('Side Cart/Mini Cart','quicker')
        ),
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-superhero-alt"></span>',
            'desc'  => esc_html__('Advertise another product to the customer during checkout and boost up your sales','quicker'),
            'title' =>esc_html__('Order Bump','quicker')
        ),
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-awards"></span>',
            'desc'  => esc_html__('Customer will pay for the order will be made upon delivery and improve your store’s sales by providing customers with a simple, secure payment method','quicker'),
            'title' =>esc_html__('Cash On Delivery Charge','quicker')
        ),
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-star-filled"></span>',
            'desc'  => esc_html__('You can set timing for breakfast, lunch and dinner. If your specified lunch time is over then that menu item will not be available for the same day again','quicker'),
            'title' =>esc_html__('Time Based Menu','quicker')
        ),
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-chart-area"></span>',
            'desc'  => esc_html__('Set a minimum order quantity for products so that you ensure the fast-moving of the inventory','quicker'),
            'title' =>esc_html__('Minimum/Maximum Order Amount','quicker')
        ),
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-rest-api"></span>',
            'desc'  => esc_html__('Create a better user experience by splitting the checkout process','quicker'),
            'title' =>esc_html__('Multi-Step Checkout','quicker')
        )
    );
    $more_products = array(
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-controls-repeat"></span>',
            'url_demo' => 'https://woooplugin.com/ultimate-membership/',
            'url_free' => 'https://downloads.wordpress.org/plugin/create-members.latest-stable.zip',
            'title' =>esc_html__('Ultimate Membership','quicker'),
            'logo'   => 'membership.png',
            'desc'   => esc_html__('Restrict content, manage member subscriptions','quicker'),
            'cta_free' =>esc_html__('Free Version','quicker'),
            'cta_demo' =>esc_html__('Premium Version','quicker')
        ),
        array(
            'icon'          =>'<span class="fr-icon dashicons dashicons-controls-repeat"></span>',
            'url_demo'      => 'https://woooplugin.com/filter-plus/',
            'url_free'      => 'https://downloads.wordpress.org/plugin/filter-plus.latest-stable.zip',
            'title'         => esc_html__('Advanced Filter for Wordpress and WooCommerce','quicker'),
            'logo'          => 'filter-plus.png',
            'desc'          => esc_html__('Allow users to filter and shortlist easily.','quicker'),
            'cta_free'      => esc_html__('Free Version','quicker'),
            'cta_demo'      => esc_html__('Premium Version','quicker')
        ),
        array(
            'icon' =>'<span class="fr-icon dashicons dashicons-controls-repeat"></span>',
            'url_demo' => 'https://woooplugin.com/discountify/',
            'url_free' => 'https://downloads.wordpress.org/plugin/quicker.latest-stable.zip',
            'title' =>esc_html__('Discount and Coupon Management','quicker'),
            'logo'   => 'discountify.png',
            'desc'   => esc_html__('Transform Discounts into Profits','quicker'),
            'cta_free' =>esc_html__('Free Version','quicker'),
            'cta_demo' =>esc_html__('Premium Version','quicker')
        ),
    );
?>
<div class="block first-block">
    <div class="left-block mb-5">
        <h1 class="first-header"><?php esc_html_e('Convert Your Browsers into Buyers and Maximize Conversions','quicker');?></h1>
        <p><?php esc_html_e('Your customers deserve a shopping experience that’s as smooth as silk. Quicker is your ultimate solution for a seamless and hassle-free WooCommerce quick checkout plugin. Say hello to higher conversion rates.','quicker');?></p>
        <div class="cta">
        <a target="_blank" href="https://www.woooplugin.com/quicker/">
            <button class="btn ctn-button"><?php esc_html_e('Explore Quicker Pro','quicker');?></button>
        </a>
    </div>
    </div>
    <div class="right-block p-2">
        <img src = "<?php echo esc_url(Quicker::assets_url().'images/quicker-banner.png') ?>"
            alt="discountify-banner" 
            width="500px"
        />
    </div>
</div>
<div class="over-view-wrapper">
    <div class="features-section mt-5">
        <div class="text-center pt-5 pb-2">
            <div class="block-header"><?php esc_html_e('Update Your Checkout Process with Advanced Quick Checkout Plugin','quicker');?></div>
            <p><?php esc_html_e('Available at Quicker Pro','quicker');?></p>
        </div>
        <div class="block-wrapper mb-5">
            <?php foreach ($features as $key => $value) { ?>
                <div class="single-item">
                        <?php echo Quicker\Utils\Helper::kses($value['icon']); ?>  
                        <h3><?php echo esc_html( $value['title'] ); ?></h3>   
                        <p><?php echo esc_html( $value['desc'] ); ?></p>   
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="block cta-block p-7 mb-5 mt-5">
        <div class="heading-block">
            <h1 class="cta-block-header"><?php esc_html_e('Explore the premium version to experience our countless advanced features.','quicker');?></h1>
        </div>
        <div class="cta-action">
            <a target="_blank" href="https://www.woooplugin.com/discountify/">
                <button class="btn feature-cta"><?php esc_html_e('Look Into Pro','quicker');?></button>
            </a>
        </div>
    </div>
    <div class="more-products-section">
        <div class="more-product-header text-center pt-5 pb-2">
            <div class="block-header"><?php esc_html_e('More Plugins By The Same Team','filter-plus');?></div>
            <p><?php esc_html_e('We also have other solutions for growing your store conversion.','filter-plus');?></p>
        </div>
        <div class="card-wrapper mb-5">
            <?php foreach ($more_products as $key => $value) {
                ?>
                <div class="card-block">
                    <img src="<?php echo esc_url(Quicker::assets_url().'images/'.$value['logo']); ?> " 
                    alt="<?php echo esc_html($value['title']);?>"/>
                    <div class="description">
                        <div class="desc">
                            <a href="<?php echo esc_url($value['url_demo']); ?>" target="_blank"><h3><?php esc_html_e($value['title'],'filter-plus'); ?></h3></a>
                            <p><?php echo esc_html($value['desc']); ?></p>  
                        </div>
                        <div class="explore-plugin">
                            <a class="btn free-button" href="<?php echo esc_url($value['url_free']); ?>"  target="_blank"><?php esc_html_e($value['cta_free'],'filter-plus'); ?></a>  
                            <a class="btn pro-button" href="<?php echo esc_url($value['url_demo']); ?>"  target="_blank"><?php esc_html_e($value['cta_demo'],'filter-plus'); ?></a>  
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>