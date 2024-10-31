<?php
/**
 * Ajax functionalities for the addon
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

use Posterno\Favourites\FavouritesList;
use Posterno\Favourites\Plugin;
use Posterno\Favourites\User;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Add a listing to the favs list.
 *
 * @return void
 */
function pno_favs_toggle_listing() {

	check_ajax_referer( 'pno_toggle_listing_favs', 'nonce' );

	if ( ! is_user_logged_in() ) {
		return;
	}

	$listing_id = isset( $_POST['listing'] ) ? absint( $_POST['listing'] ) : false;
	$user_id    = get_current_user_id();

	if ( User::has_a_list( $user_id ) ) {

		// Remove the listing from being bookmarked.
		if ( User::bookmarked_listing( $listing_id, $user_id ) ) {

			User::remove_listing( $listing_id, $user_id );

			wp_send_json_success( [ 'bookmark' => 'removed' ] );

		} else {

			$existing_list = Plugin::instance()->queries->get_item_by( 'user_id', $user_id );

			if ( $existing_list instanceof FavouritesList ) {
				FavouritesList::add_listing( $listing_id, $existing_list->get_id() );
			}

		}

	} else {

		$new_list = FavouritesList::create( false, $listing_id, $user_id );

	}

	wp_send_json_success( [ 'bookmark' => 'added' ] );

}
add_action( 'wp_ajax_pno_favs_toggle_listing', 'pno_favs_toggle_listing' );
