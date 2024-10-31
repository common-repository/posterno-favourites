<?php
/**
 * Actions for the addon.
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
 * Detect fav action when logging in and verify the nonce before triggering the store action.
 */
add_action(
	'pno_after_user_login',
	function() {

		$array = [];
		$url   = pno_get_login_redirect();

		parse_str( wp_parse_url( $url, PHP_URL_QUERY ), $array );

		if ( isset( $array['action'] ) && $array['action'] === 'fav' ) {
			if ( ! isset( $array['bookmark_nonce'] ) || ! wp_verify_nonce( $array['bookmark_nonce'], 'bookmarking_listing' ) ) {
				wp_die( esc_html__( 'Something went wrong while bookmarking this listing.', 'posterno-favourites' ) );
			}
		}

	}
);

/**
 * Detect fav action url and trigger bookmarking functionality.
 */
add_action(
	'init',
	function() {

		//phpcs:ignore
		if ( ! isset( $_GET['action'] ) || ! is_user_logged_in() ) {
			return;
		}

		//phpcs:ignore
		if ( isset( $_GET['action'] ) && $_GET['action'] === 'fav' ) {

			//phpcs:ignore
			$listing_id = isset( $_GET['listing'] ) ? absint( $_GET['listing'] ) : false;

			if ( get_post_type( $listing_id ) !== 'listings' ) {
				wp_die( esc_html__( 'Something went wrong while bookmarking this listing.', 'posterno-favourites' ) );
			}

			$list = User::get_list( get_current_user_id() );

			if ( $list instanceof FavouritesList ) {

				$list::add_listing( $listing_id, $list->get_id() );

				$redirect = add_query_arg( [ 'bookmarked' => true ], get_permalink( $listing_id ) );

				wp_safe_redirect( $redirect );
				exit;

			}
		}

	}
);

/**
 * Display a confirmation notice when a listing has been successfully bookmarked.
 *
 * @return void
 */
function pno_favs_display_single_success_notice() {

	//phpcs:ignore
	if ( ! isset( $_GET['bookmarked'] ) ) {
		return;
	}

	/**
	 * Filter: allows developers to modify the success message displayed when adding
	 * a listing to the favs list from the single listing page.
	 *
	 * @param string $message the original message.
	 * @return string
	 */
	$message = apply_filters( 'pno_favs_success_message', esc_html__( 'Listing successfully added to your favourites.', 'posterno-favourites' ) );

	posterno()->templates
		->set_template_data(
			[
				'type'    => 'success',
				'message' => wp_kses_post( $message ),
			]
		)
		->get_template_part( 'message' );

}
add_action( 'pno_before_single_listing', 'pno_favs_display_single_success_notice' );

/**
 * Detect when a listing is being removed from the bookmarks and remove it from all lists.
 */
add_action(
	'init',
	function() {

		if ( ! isset( $_GET['bookmark_remove_nonce'] ) || ! wp_verify_nonce( $_GET['bookmark_remove_nonce'], 'removing_listing_bookmark' ) ) {
			return;
		}

		if ( ! is_user_logged_in() ) {
			return;
		}

		if ( isset( $_GET['action'] ) && $_GET['action'] === 'remove-fav' ) {

			//phpcs:ignore
			$listing_id = isset( $_GET['listing'] ) ? absint( $_GET['listing'] ) : false;

			if ( get_post_type( $listing_id ) !== 'listings' ) {
				wp_die( esc_html__( 'Something went wrong while removing this listing from your favourites.', 'posterno-favourites' ) );
			}

			User::remove_listing( $listing_id, get_current_user_id() );

			$redirect_url = add_query_arg( [ 'bookmark' => 'removed' ], get_permalink( $listing_id ) );

			wp_safe_redirect( $redirect_url );
			exit;

		}

	}
);

/**
 * Display a notice when a listing is removed from the bookmarks when triggered on
 * the single listing page.
 *
 * @return void
 */
function pno_favs_display_single_removal_success_notice() {

	if ( ! isset( $_GET['bookmark'] ) || isset( $_GET['bookmark'] ) && $_GET['bookmark'] !== 'removed' ) {
		return;
	}

	/**
	 * Filter: allows developers to modify the success message displayed when removing
	 * a listing from the favs list from the single listing page.
	 *
	 * @param string $message the original message.
	 * @return string
	 */
	$message = apply_filters( 'pno_favs_removal_success_message', esc_html__( 'Listing successfully removed from your favourites.', 'posterno-favourites' ) );

	posterno()->templates
		->set_template_data(
			[
				'type'    => 'success',
				'message' => wp_kses_post( $message ),
			]
		)
		->get_template_part( 'message' );

}
add_action( 'pno_before_single_listing', 'pno_favs_display_single_removal_success_notice' );

/**
 * Load the content for the favourites section in the frontend dashboard.
 *
 * @return void
 */
function pno_favs_display_favourites_list() {

	Plugin::instance()->templates->get_template_part( 'dashboard-list' );

}
add_action( 'pno_dashboard_tab_content_favourites', 'pno_favs_display_favourites_list' );

/**
 * Detect when a user is removing a listing from it's favourites list.
 */
add_action(
	'init',
	function() {

		if ( ! isset( $_POST['dashboard_favs_removal_nonce'] ) || ! wp_verify_nonce( $_POST['dashboard_favs_removal_nonce'], 'removing_bookmark_from_dashboard' ) || ! is_user_logged_in() ) {
			return;
		}

		$user_id    = get_current_user_id();
		$listing_id = isset( $_POST['listing_id'] ) && ! empty( $_POST['listing_id'] ) ? absint( $_POST['listing_id'] ) : false;

		if ( $listing_id ) {

			User::remove_listing( $listing_id, $user_id );

			$redirect = add_query_arg( [ 'bookmark' => 'removed' ], trailingslashit( get_permalink( pno_get_dashboard_page_id() ) ) . 'favourites' );

			wp_safe_redirect( $redirect );
			exit;

		}

	}
);
