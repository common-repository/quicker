<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<header class="menu">
    <a href='https://woooplugin.com/quicker/' target="_blank">
        <div class="logo">
            <img src = "<?php echo esc_url(Quicker::assets_url().'images/quicker-icon.svg') ?>"
                alt="quicker-logo" 
                width="48px"
            />
            <span class='version'><?php echo esc_html('v '.Quicker::get_version());?></span>
        </div>
    </a>
    <?php
        $menus = array( 
            array(
                'name' => esc_html__('Settings','quicker'),
                'url' => admin_url().'admin.php?page=quicker-settings',
                'slug'=>'quicker-settings',
                'target'=>'_self'
            ),
            array(
                'name' => esc_html__('Checkout Fields','quicker'),
                'url' => admin_url().'admin.php?page=quicker-checkout-fields',
                'slug'=>'quicker-checkout-fields',
                'target'=>'_self'
            ),
            array(
                'name' => esc_html__('Support','quicker'),
                'url' => 'https://woooplugin.com/support/',
                'target'=>'_blank'
            ),
            array(
                'name' => esc_html__('Feature Request','quicker'),
                'url' => 'https://app.loopedin.io/quicker#/roadmap',
                'target'=>'_blank'
            ),
           
        );
        
        if (!class_exists('QuickerPro')) {
            $menus[] =  array(
                'name' => esc_html__('Upgrade to Pro','quicker'),
                'url' => 'https://woooplugin.com/quicker/',
                'target'=>'_blank'
            );
        }
    ?>
    <div class="navigation">
        <?php
            $filter_menus= ['quicker-settings'];
            $current_page = !empty($_GET['page']) ? $_GET['page'] : '';
            foreach ($menus as $key => $value) {
                $active = (!empty($value['slug']) && $value['slug'] == $current_page ) ? 'active' : '';
                $class= $value === end( $menus ) ? 'upgrade_pro':'';
                ?>
                <li>
                    <a class="<?php echo esc_attr($class).' '.esc_attr($active);?>" href="<?php echo esc_url($value['url'])?>"
                     target="<?php echo esc_attr($value['target']); ?>">
                    <?php echo esc_html($value['name']);?>
                    </a>
                </li>
                <?php
            }
        ?>
    </div>
</header>