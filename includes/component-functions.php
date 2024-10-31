<?php
/**
 * Component Functions
 *
 * This file includes functions for interacting with PNO components. An PNO
 * component is comprised of:
 *
 * - Database table/schema/query
 * - Object interface
 * - Optional meta-data
 *
 * Add-ons and third party plugins are welcome to register their own component
 * in exactly the same way that PNO does internally.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Register database components for this addon.
 *
 * @return void
 */
function pno_favs_setup_components() {

	static $setup = false;

	if ( false !== $setup ) {
		return;
	}

	pno_register_component(
		'reviews',
		array(
			'schema' => '\\Posterno\\Favourites\\Database\\Schemas\\Favourites',
			'table'  => '\\Posterno\\Favourites\\Database\\Tables\\Favourites',
			'query'  => '\\Posterno\\Favourites\\Database\\Queries\\Favourites',
			'object' => '\\Posterno\\Favourites\\FavouritesList',
			'meta'   => false,
		)
	);

	$setup = true;

	do_action( 'pno_favs_setup_components' );

}
