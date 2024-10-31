<?php
/**
 * Favourites database table table.
 *
 * @package     posterno-favourites
 * @copyright   Copyright (c) 2019, Sematico, LTD
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

namespace Posterno\Favourites\Database\Tables;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use PNO\Database\Table;

/**
 * Setup the global "pno_favourites" database table
 *
 * @since 0.1.0
 */
final class Favourites extends Table {

	/**
	 * Table name
	 *
	 * @access protected
	 * @since 0.1.0
	 * @var string
	 */
	protected $name = 'pno_favourites';

	/**
	 * Database version
	 *
	 * @access protected
	 * @since 0.1.0
	 * @var int
	 */
	protected $version = 201808170001;

	/**
	 * Array of upgrade versions and methods
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	protected $upgrades = [];

	/**
	 * Setup the database schema
	 *
	 * @access protected
	 * @since 0.1.0
	 * @return void
	 */
	protected function set_schema() {
		$this->schema = "id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			user_id bigint(20) unsigned NOT NULL default '0',
			title longtext NOT NULL,
			listings longtext NOT NULL default '',
			public boolean NOT NULL default 0,
			date_created datetime NOT NULL default '0000-00-00 00:00:00',
			date_updated datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY (id),
			KEY user_id (user_id)";
	}

}
