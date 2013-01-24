<?php
/*
Plugin Name: Piklist Field Addons
Plugin URI: 
Version: v0.1
Author: Adam Anderly
Plugin Type: Piklist
 */

/*  This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// -------------------------------------------------------------------------
// Prevent direct access to this file
// -------------------------------------------------------------------------
if ( ! function_exists ( 'add_action' ) ) :
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
endif;

if ( !defined('ABSPATH') ) {
	exit;
}

define( 'PIKLIST_FIELD_ADDONS_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'PIKLIST_FIELD_ADDONS_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

if ( !class_exists( 'Piklist_Field_Addons' ) ) {
	include_once 'includes/class-piklist-field-addons.php';

	Piklist_Field_Addons::load();
}
  
?>