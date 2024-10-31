<?php
/**
 * Register shortcodes for the addon.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

use Posterno\Favourites\Plugin;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Displays the add/remove favourites button for a specific listing.
 *
 * @param mixed $atts attributes of the shortcode.
 * @return string
 */
function pno_favs_listing_button( $atts ) {

	ob_start();

	Plugin::instance()->templates
		->set_template_data( $atts )
		->get_template_part( 'button-shortcode' );

	$out = ob_get_clean();

	return $out;

}
add_shortcode( 'pno_favourite_listing', 'pno_favs_listing_button' );
