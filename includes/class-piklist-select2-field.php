<?php

class Piklist_Select2_Field
{
	public static $view_path = null;

	public static function _construct() {
		self::$view_path = WP_CONTENT_URL . '/plugins/piklist/parts/fields/select.php';
		add_action( 'admin_enqueue_scripts', array('piklist_select2_field', 'scripts') );
    	add_action( 'wp_enqueue_scripts', array('piklist_select2_field', 'scripts') );
	}

	public static function scripts() {
		global $wp_scripts;

		if ( !is_object( $wp_scripts ) ) {
			return false;
		}

		wp_register_style( 'jquery-select2', PIKLIST_FIELD_ADDONS_URL . 'css/select2/select2.css', false, '3.2' );
		wp_register_script( 'jquery-select2', PIKLIST_FIELD_ADDONS_URL . 'js/select2/select2.min.js', array('jquery'), '3.2', true );

		wp_enqueue_script( 'jquery-select2' );
		wp_enqueue_style( 'jquery-select2' );
	}
}

?>