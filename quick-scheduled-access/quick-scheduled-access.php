<?php
/**
 * @package Quick_Scheduled_Access
 * @author Romain Schmitz
 * @version 1.0
 */
/*
Plugin Name: Quick Scheduled Access
Version: 1.0
Plugin URI: http://slopjong.de
Author: Romain Schmitz
Author URI: http://slopjong.de
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Description: Adds a link to Scheduled under the Posts, Pages, and other custom post type sections in the admin menu.

Compatible with WordPress 3.1 through 3.5+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/quick-scheduled-access/
*/

// This code is based on the plugin Quick Draft Access written by Scott Reilly

/*
	Copyright (c) 2010-2013 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( is_admin() && ! class_exists( 'slop_QuickScheduledAccess' ) ) :

class slop_QuickScheduledAccess {

	function init() {
		add_action( 'admin_menu', array( __CLASS__, 'quick_scheduled_access' ) );
	}

	function quick_scheduled_access() {
	
		global $wpdb;
		
		$post_types = (array) get_post_types( array( 'show_ui' => true ), 'object' );
		$post_types = apply_filters( 'slop_quick_scheduled_access_post_types', $post_types );
		$post_status = null;

		foreach ( $post_types as $post_type ) {
					
			$name = $post_type->name;
			
			// TODO: a better way to get the amount of future posts is described in [0]
			$num_future = $wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` WHERE post_type='$name' AND post_status='future'");

			if ( ( $num_future > 0 ) || apply_filters( 'slop_quick_scheduled_access_show_if_empty', false, $name, $post_type ) ) {
				$path = 'edit.php';
				if ( 'post' != $name ) // edit.php?post_type=post doesn't work
					$path .= '?post_type=' . $name;

				if ( ! $post_status )
					$post_status = get_post_status_object( 'future' );

				add_submenu_page( $path, __( 'Scheduled' ),
					sprintf( translate_nooped_plural( $post_status->label_count, $num_future ), number_format_i18n( $num_future ) ),
					$post_type->cap->edit_posts, "edit.php?post_type=$name&post_status=future" );
			}
		}
	}
}

slop_QuickScheduledAccess::init();

endif;

// [0] http://stackoverflow.com/questions/10246370/wordpress-check-if-there-is-an-post-to-be-published-in-future
