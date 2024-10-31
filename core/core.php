<?php

namespace Quicker\Core;

use Quicker\Utils\Singleton;

/**
 * Base Class
 *
 * @since 1.0.0
 */
class Core {

    use Singleton;

    /**
     * Initialize all modules.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init() {
      if (!is_admin()) {
        // Load frontend 
        \Quicker\Core\Frontend\Frontend::instance()->init();
      }else{
        \Quicker\Core\Admin\Menus::instance()->init();
        // Ajax submit
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
          \Quicker\Core\Admin\Settings\Settings::instance()->init();
        }
      }
      // addons
      \Quicker\Core\Modules\Product_Addons\Product_Addons::instance()->init();

    }
}
