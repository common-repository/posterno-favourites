<?php
/**
 * Load assets for the addon.
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
 * Load frontend assets for the addon.
 *
 * @return void
 */
function pno_favs_load_assets() {

	wp_register_script( 'pno-favs', PNO_FAVOURITES_PLUGIN_URL . 'dist/js/app.js', [ 'jquery' ], PNO_FAVOURITES_VERSION, true );
	wp_enqueue_script( 'pno-favs' );


	ob_start();

	Plugin::instance()->templates->get_template_part( 'added-notice' );

	$markup = ob_get_clean();

	ob_start();

	Plugin::instance()->templates->get_template_part( 'removed-notice' );

	$markup_2 = ob_get_clean();

	wp_localize_script(
		'pno-favs',
		'pnoFavs',
		[
			'ajax'                => admin_url( 'admin-ajax.php' ),
			'AddedNoticeMarkup'   => esc_js( str_replace( "\n", '', $markup ) ),
			'RemovedNoticeMarkup' => esc_js( str_replace( "\n", '', $markup_2 ) ),
			'nonce'               => wp_create_nonce( 'pno_toggle_listing_favs' ),
		]
	);

}
add_action( 'wp_enqueue_scripts', 'pno_favs_load_assets' );

/**
 * Add a custom color to the favs icon when a listing has already been bookmarked.
 *
 * @return void
 */
function pno_favs_custom_css() {

	?>
	<style>
		.pno-fav-link.liked {
			color:#ff2f42;
		}
	</style>
	<?php

}
add_action( 'wp_footer', 'pno_favs_custom_css' );
