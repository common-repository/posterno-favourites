<?php
/**
 * Addon filters.
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
 * Loads the favorites action icon within listings cards.
 *
 * @param array  $items existing items registered.
 * @param string $listing_id the id of the listing being loaded.
 * @param string $layout the layout of the card being loaded.
 * @return array
 */
function pno_favs_add_fav_icon( $items, $listing_id, $layout ) {

	ob_start();

	Plugin::instance()->templates
		->set_template_data(
			[
				'listing_id' => $listing_id,
				'layout'     => $layout,
			]
		)
		->get_template_part( 'action' );

	$output = ob_get_clean();

	$items[] = $output;

	return $items;

}
add_filter( 'pno_listing_card_details', 'pno_favs_add_fav_icon', 10, 3 );

/**
 * Add the Favs icon to the single listing details page.
 *
 * @param array $lists list of previously registered items.
 * @return array
 */
function pno_favs_add_fav_icon_single_listing( $lists ) {

	ob_start();

	Plugin::instance()->templates
		->set_template_data(
			[
				'listing_id' => get_queried_object_id(),
				'layout'     => false,
			]
		)
		->get_template_part( 'button' );

	$output = ob_get_clean();

	$lists[] = $output;

	return $lists;

}
add_filter( 'pno_single_listing_details_list', 'pno_favs_add_fav_icon_single_listing' );

/**
 * Registers the favourites section within the user's dashboard.
 *
 * @param array $items currently available sections.
 * @return array
 */
function pno_favs_register_dashboard_section( $items ) {

	$items['favourites'] = [
		'name'     => esc_html__( 'Favourites', 'posterno-favourites' ),
		'priority' => 5,
	];

	return $items;

}
add_filter( 'pno_dashboard_navigation_items', 'pno_favs_register_dashboard_section', 10 );

/**
 * Hide the favourites menu item when not logged in.
 *
 * @param object $menu_item menu item object.
 * @return object
 */
function pno_favs_setup_nav_menu_item( $menu_item ) {

	if ( is_admin() ) {
		return $menu_item;
	}
	// Prevent a notice error when using the customizer.
	$menu_classes = $menu_item->classes;

	if ( is_array( $menu_classes ) ) {
		$menu_classes = implode( ' ', $menu_item->classes );
	}

	// We use information stored in the CSS class to determine what kind of
	// menu item this is, and how it should be treated.
	preg_match( '/\spno-(.*)-nav/', $menu_classes, $matches );

	// If this isn't a PNO menu item, we can stop here.
	if ( empty( $matches[1] ) ) {
		return $menu_item;
	}

	switch ( $matches[1] ) {
		case 'favourites':
			if ( ! is_user_logged_in() ) {
				$menu_item->_invalid = true;
			} else {
				$menu_item->url = pno_get_dashboard_navigation_item_url( $matches[1] );
			}
			break;
	}

	$menu_item->pno_identifier = $matches[1];

	return $menu_item;

}
add_filter( 'wp_setup_nav_menu_item', 'pno_favs_setup_nav_menu_item', 10, 1 );
