<?php
/**
 * Helper methods for this addon.
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
 * Helper methods collection for this addon.
 */
class Helper {

	/**
	 * Get the link to add a listing to the favourites list when not logged in.
	 *
	 * @param string $listing_id the id of the listing to add to the list.
	 * @return string
	 */
	public static function get_user_add_link( $listing_id ) {

		$logged_redirect = wp_nonce_url(
			add_query_arg(
				[
					'action'  => 'fav',
					'listing' => absint( $listing_id ),
				],
				get_permalink( $listing_id )
			),
			'bookmarking_listing',
			'bookmark_nonce'
		);

		if ( is_user_logged_in() ) {

			return $logged_redirect;

		} else {

			return add_query_arg(
				[
					'redirect_to' => rawurlencode( $logged_redirect ),
				],
				get_permalink( pno_get_login_page_id() )
			);

		}

	}

	/**
	 * Get the link to remove a list from the favs list.
	 *
	 * @param string $listing_id the id number of the object.
	 * @return string
	 */
	public static function get_user_listing_removal_link( $listing_id ) {

		return wp_nonce_url(
			add_query_arg(
				[
					'action'  => 'remove-fav',
					'listing' => absint( $listing_id ),
				],
				get_permalink( $listing_id )
			),
			'removing_listing_bookmark',
			'bookmark_remove_nonce'
		);

	}

}
