<?php
/**
 * Representation of a favourites list.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2020, Sematico LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

namespace Posterno\Favourites;

use PNO\Entities\AbstractEntity;
use Posterno\Favourites\Database\Queries\Favourites;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Representation of a favourites list.
 */
class FavouritesList extends AbstractEntity {

	/**
	 * List ID.
	 *
	 * @var integer
	 */
	protected $id = 0;

	/**
	 * The ID number of the user to which the list belong to.
	 *
	 * @var integer
	 */
	protected $user_id = 0;

	/**
	 * Whether or not the list can be viewed by other members.
	 *
	 * @var boolean
	 */
	protected $public = false;

	/**
	 * The title of the list.
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * Listings assigned to the list.
	 *
	 * @var array
	 */
	protected $listings = [];

	/**
	 * When the list was created.
	 *
	 * @var string
	 */
	protected $date_created = '';

	/**
	 * When the list was last updated.
	 *
	 * @var string
	 */
	protected $date_updated = '';

	/**
	 * Get things started.
	 *
	 * @param mixed $args database items sent through the entity.
	 */
	public function __construct( $args = null ) {
		parent::__construct( $args );
	}

	/**
	 * Get the id number of the user assigned to the list.
	 *
	 * @return int|string
	 */
	public function get_user_id() {
		return $this->user_id;
	}

	/**
	 * Whether or not the list is public.
	 *
	 * @return boolean
	 */
	public function is_public() {
		return (bool) $this->public;
	}

	/**
	 * Get the title of the list.
	 *
	 * @return string
	 */
	public function get_title() {
		return empty( $this->title ) ? esc_html__( 'Untitled list', 'posterno-favourites' ) : $this->title;
	}

	/**
	 * Get the list of listings assigned to the list.
	 *
	 * @return array
	 */
	public function get_listings() {
		return json_decode( $this->listings, true );
	}

	/**
	 * Get the date when the list was created.
	 *
	 * @return string
	 */
	public function get_date_created() {
		return $this->date_created;
	}

	/**
	 * Get the date when the list was last updated.
	 *
	 * @return string
	 */
	public function get_date_updated() {
		return $this->date_updated;
	}

	/**
	 * Create a new favourites list and optionally append a listing if available.
	 *
	 * @param string  $title the title of the list.
	 * @param boolean $listing_id optionally append a listing too.
	 * @param string  $user_id the user id of who the list belongs to.
	 * @return string
	 */
	public static function create( $title = false, $listing_id = false, $user_id = false ) {

		if ( ! $title ) {
			$title = esc_html__( 'Untitled list', 'posterno-favourites' );
		}

		$query = new Favourites();

		if ( $listing_id ) {
			$listing_id = absint( $listing_id );
		}

		return $query->add_item(
			[
				'user_id'      => empty( $user_id ) ? get_current_user_id() : absint( $user_id ),
				'title'        => sanitize_text_field( $title ),
				'listings'     => wp_json_encode( [ $listing_id ] ),
				'date_created' => current_time( 'mysql' ),
			]
		);

	}

	/**
	 * Add a listing to the favs list.
	 *
	 * @param string $listing_id the id number.
	 * @param string $list_id the id number.
	 * @return void
	 */
	public static function add_listing( $listing_id, $list_id ) {

		$query = Plugin::instance()->queries->get_item_by( 'id', $list_id );

		if ( $query instanceof FavouritesList ) {

			$new_listings = array_merge( $query->get_listings(), [ $listing_id ] );

			Plugin::instance()->queries->update_item(
				$list_id,
				[
					'listings'     => wp_json_encode( array_unique( $new_listings ) ),
					'date_updated' => current_time( 'mysql' ),
				]
			);

		}

	}

	/**
	 * Remove a listing from the bookmarked ones.
	 *
	 * @param string $listing_id the listing to remove.
	 * @return void
	 */
	public function remove_listing( $listing_id ) {

		$available_listings = $this->get_listings();

		$key = array_search( $listing_id, $available_listings, true );

		if ( $key !== false ) {
			unset( $available_listings[ $key ] );
		}

		Plugin::instance()->queries->update_item(
			$this->get_id(),
			[
				'listings'     => wp_json_encode( array_unique( $available_listings ) ),
				'date_updated' => current_time( 'mysql' ),
			]
		);

	}

}
