<?php
/**
 * User Helper methods for this addon.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

namespace Posterno\Favourites;

use Posterno\Favourites\Database\Queries\Favourites;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * User Helper methods collection for this addon.
 */
class User {

	/**
	 * Determine if a user already has a favourites list.
	 *
	 * @param string $user_id the id number of the user to verify.
	 * @return bool
	 */
	public static function has_a_list( $user_id ) {
		$query = Plugin::instance()->queries->get_item_by( 'user_id', $user_id );

		return ! empty( $query );
	}

	/**
	 * Get the favourites list of a user.
	 *
	 * @param string $user_id the id number of the user.
	 * @return \Posterno\Favourites\FavouritesList
	 */
	public static function get_list( $user_id ) {

		return Plugin::instance()->queries->get_item_by( 'user_id', $user_id );

	}

	/**
	 * Determine if a user has bookmarked a specific listing.
	 *
	 * @param string $listing_id the id number of the listing to verify.
	 * @param string $user_id the user being verified.
	 * @return bool
	 */
	public static function bookmarked_listing( $listing_id, $user_id ) {

		$query = new Favourites(
			[
				'user_id__in' => [ $user_id ],
			]
		);

		if ( isset( $query->items ) && ! empty( $query->items ) && is_array( $query->items ) ) {
			foreach ( $query->items as $list ) {
				if ( $list instanceof FavouritesList && in_array( $listing_id, $list->get_listings(), true ) ) {
					return true;
				}
			}
		}

		return false;

	}

	/**
	 * Remove a listing from all the lists the user has created.
	 *
	 * @param string $listing_id the id number.
	 * @param string $user_id the id number.
	 * @return void
	 */
	public static function remove_listing( $listing_id, $user_id ) {

		$query = new Favourites(
			[
				'user_id__in' => [ $user_id ],
			]
		);

		if ( isset( $query->items ) && ! empty( $query->items ) && is_array( $query->items ) ) {
			foreach ( $query->items as $list ) {
				if ( $list instanceof FavouritesList && in_array( $listing_id, $list->get_listings(), true ) ) {
					$list->remove_listing( $listing_id );
				}
			}
		}

	}

}
