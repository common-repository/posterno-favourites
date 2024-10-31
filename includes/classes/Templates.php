<?php
/**
 * Setup the templates loader for this addon.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

namespace Posterno\Favourites;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Dynamic templates loader for the addon.
 */
class Templates extends \PNO_Templates {

	/**
	 * Directory name where templates should be found into the theme.
	 *
	 * @var string
	 */
	protected $theme_template_directory = 'posterno/favourites';

	/**
	 * Current plugin's root directory.
	 *
	 * @var string
	 */
	protected $plugin_directory = PNO_FAVOURITES_PLUGIN_DIR;

}
