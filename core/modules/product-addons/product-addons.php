<?php

namespace Quicker\Core\Modules\Product_Addons;

use Quicker\Utils\Singleton;
use Quicker\Core\Modules\Product_Addons\Admin as Product_Addons_Admin;

/**
 * Base Class
 *
 * @since 1.0.0
 */
class Product_Addons {

    use Singleton;

    /**
     * Initialize all modules.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function init() {
		if (is_admin()) {
			Product_Addons_Admin\Hooks::instance()->init();
		}

    }
}
