<?php
/**
 * Plugin Name:     Posterno Favourites
 * Plugin URI:      https://posterno.com/extensions/favourites
 * Description:     Allows users to keep a list of favorite listings. This is a Posterno extension.
 * Author:          Posterno
 * Author URI:      https://posterno.com
 * Text Domain:     posterno-favourites
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * Posterno Favourites is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Posterno Favourites is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Posterno Favourites. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package posterno-favourites
 * @author Posterno
 */

namespace Posterno\Favourites;

defined( 'ABSPATH' ) || exit;

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * Activate the plugin only when requirements are met.
 */
add_action(
	'plugins_loaded',
	function() {

		$requirements_check = new \PosternoRequirements\Check(
			array(
				'title' => 'Posterno Favourites',
				'file'  => __FILE__,
				'pno'   => '1.2.4',
			)
		);

		if ( $requirements_check->passes() ) {

			$addon = Plugin::instance( __FILE__ );
			add_action( 'plugins_loaded', [ $addon, 'textdomain' ], 11 );

		}
		unset( $requirements_check );

	}
);

/**
 * Install addon's required data on plugin activation.
 */
register_activation_hook(
	__FILE__,
	function() {

		$requirements_check = new \PosternoRequirements\Check(
			array(
				'title' => 'Posterno Favourites',
				'file'  => __FILE__,
				'pno'   => '1.2.4',
			)
		);

		if ( $requirements_check->passes() ) {
			$addon = Plugin::instance( __FILE__ );
			$addon->install();
		}
		unset( $requirements_check );

	}
);
