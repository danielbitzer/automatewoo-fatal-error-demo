<?php
/**
 * Plugin Name: AutomateWoo Fatal Error Demo
 * Description: Breaks AutomateWoo for demo purposes.
 * Plugin URI: https://github.com/danielbitzer/automatewoo-fatal-error-demo
 * Version: 1.0.0
 * Author: Dan Bitzer
 * Author URI: https://github.com/danielbitzer
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace AutomateWoo\Fatal_Error_Demo;

function load() {
	fatal_error_1();
	fatal_error_2();
}

/**
 * Fatal error demo #1
 *
 * This demo create an WooCommerce order action called 'Sync order with ShipStation'
 * which works sometimes and other times it does not...
 */
function fatal_error_1() {
	add_filter( 'woocommerce_order_actions', function ( $actions ) {
		$actions['automatewoo_fatal_error_demo_order_action'] = 'Sync order with ShipStation';

		return $actions;
	} );

	add_action( 'woocommerce_order_action_automatewoo_fatal_error_demo_order_action', function ( $order ) {
		// Function doesn't exist when workflow runs, oh no!
		my_awesome_function();
	} );

	// Load a function, only for the post edit screen
	add_action( 'load-post.php', function () {
		function my_awesome_function() {
		}
	} );
}

/**
 * Fatal error demo #2
 *
 * This demo simply breaks the asnyc subscription status changed event by
 * hooking in with too many args in the function.
 */
function fatal_error_2() {
	add_action( 'automatewoo/subscription/status_changed_async', function ( $too, $many, $args ) {
	}, 5 );
}


add_action( 'automatewoo_loaded', 'AutomateWoo\Fatal_Error_Demo\load' );
