<?php
/**
 * Favourites database queries.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

namespace Posterno\Favourites\Database\Queries;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use PNO\Database\Query;

/**
 * Class used for querying.
 *
 * @since 0.1.0
 */
class Favourites extends Query {

	/** Table Properties ******************************************************/

	/**
	 * Name of the database table to query.
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string
	 */
	protected $table_name = 'favourites';

	/**
	 * String used to alias the database table in MySQL statement.
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string
	 */
	protected $table_alias = 'favs';

	/**
	 * Name of class used to setup the database schema
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string
	 */
	protected $table_schema = '\\Posterno\\Favourites\\Database\\Schemas\\Favourites';

	/** Item ******************************************************************/

	/**
	 * Name for a single item
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string
	 */
	protected $item_name = 'list';

	/**
	 * Plural version for a group of items.
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string
	 */
	protected $item_name_plural = 'lists';

	/**
	 * Callback function for turning IDs into objects
	 *
	 * @since 0.1.0
	 * @access public
	 * @var mixed
	 */
	protected $item_shape = '\\Posterno\\Favourites\\FavouritesList';

	/** Cache *****************************************************************/

	/**
	 * Group to cache queries and queried items in.
	 *
	 * @since 0.1.0
	 * @access public
	 * @var string
	 */
	protected $cache_group = 'favs_lists';

	/**
	 * Whether this is a table coming from an addon.
	 *
	 * @var boolean
	 */
	public $addon_table = true;

	/** Methods ***************************************************************/

	/**
	 * Sets up the query, based on the query vars passed.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @param string|array $query the query arguments.
	 */
	public function __construct( $query = array() ) {
		parent::__construct( $query );
	}
}
