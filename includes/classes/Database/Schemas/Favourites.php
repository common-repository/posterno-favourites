<?php
/**
 * Favourites database table schema.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

namespace Posterno\Favourites\Database\Schemas;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use PNO\Database\Schema;

/**
 * Database table schema definition.
 */
class Favourites extends Schema {

	/**
	 * Array of database column objects.
	 *
	 * @since  0.1.0
	 * @access public
	 * @var    array
	 */
	public $columns = array(

		array(
			'name'     => 'id',
			'type'     => 'bigint',
			'length'   => '20',
			'unsigned' => true,
			'extra'    => 'auto_increment',
			'primary'  => true,
			'sortable' => true,
		),

		array(
			'name'       => 'user_id',
			'type'       => 'bigint',
			'length'     => '20',
			'unsigned'   => true,
			'default'    => '0',
			'searchable' => true,
			'sortable'   => true,
			'transition' => true,
		),

		array(
			'name'       => 'title',
			'type'       => 'longtext',
			'default'    => '',
			'searchable' => false,
			'in'         => false,
			'not_in'     => false,
		),

		array(
			'name'       => 'listings',
			'type'       => 'longtext',
			'default'    => '',
			'searchable' => false,
			'in'         => false,
			'not_in'     => false,
		),

		array(
			'name'       => 'public',
			'type'       => 'boolean',
			'default'    => 0,
			'searchable' => false,
			'in'         => false,
			'not_in'     => false,
		),

		array(
			'name'       => 'date_created',
			'type'       => 'datetime',
			'default'    => '0000-00-00 00:00:00',
			'created'    => true,
			'date_query' => true,
			'sortable'   => true,
		),

		array(
			'name'       => 'date_updated',
			'type'       => 'datetime',
			'default'    => '0000-00-00 00:00:00',
			'created'    => true,
			'date_query' => true,
			'sortable'   => true,
		),

	);

}
