<?php

namespace Quicker\Core\Frontend;

defined( 'ABSPATH' ) || exit;

use Quicker\Utils\Singleton;

/**
 * Base Class
 *
 * @since 1.0.0
 */
class Frontend {

 	use Singleton;

	public function init(){
		\Quicker\Core\Frontend\CheckoutFields::instance()->init();
	}

}
