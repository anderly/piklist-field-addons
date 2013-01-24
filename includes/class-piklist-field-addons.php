<?php

class Piklist_Field_Addons
{  
	public static $paths = array();

	public static function load() {
		add_action( 'admin_init', array( 'Piklist_Field_Addons', 'check_dependencies' ) );  
		self::$paths['plugin'] = dirname( dirname( __FILE__ ) );

		load_plugin_textdomain( 'piklist_field_addons', false, dirname(dirname(plugin_basename(__FILE__ ))) . '/languages' );

		register_activation_hook('piklist_field_addons/piklist-field-addons.php', array('piklist_field_addons', 'install'));
		add_action( 'admin_enqueue_scripts', array('piklist_field_addons', 'scripts') );
    	add_action( 'wp_enqueue_scripts', array('piklist_field_addons', 'scripts') );

		self::auto_load();
	}

	public static function scripts() {
		wp_register_script( 'piklist-field-addons', PIKLIST_FIELD_ADDONS_URL . 'js/piklist-field-addons.js', array('piklist'), '0.1', true );

		wp_enqueue_script( 'piklist-field-addons' );
	}

	public static function check_dependencies () {
		include_once( 'class-piklist-checker.php' );
		if ( ! piklist_checker::check( __FILE__ ) ) {
			return;
		}
	}

	public static function auto_load()
	{
		$includes = self::get_directory_list( self::$paths['plugin'] . '/includes' );
		foreach ($includes as $include) {
			$class_name = str_replace( array( '.php', 'class_' ), array( '', '' ), self::slug( $include ) );
			if ( $include != __FILE__ && $include != 'class-piklist-checker.php' ) {
				include_once self::$paths['plugin'] . '/includes/' . $include;

				if ( class_exists( $class_name ) && method_exists( $class_name, '_construct' ) && !is_subclass_of( $class_name, 'WP_Widget' ) ) {
	  				call_user_func( array( $class_name, '_construct' ) );
				}
			}
		}
	}

	public static function install() {
		do_action( 'piklist_field_addons_install' );
	}

	public static function slug($string) {
		return str_replace( '.php', '', str_replace( array( '-', ' ' ), '_', strtolower( $string ) ) );
	}

	public static function get_directory_list($start = '.', $path = false, $extension = false) 
  {
    $files = array();

    if (is_dir($start)) 
    {
      $file_handle = opendir($start);

      while (($file = readdir($file_handle)) !== false) 
      {
        if ($file != '.' && $file != '..' && strlen($file) > 2) 
        {
          if (strcmp($file, '.') == 0 || strcmp($file, '..') == 0) 
          {
            continue;
          }

          if ($file[0] != '.' && $file[0] != '_')
          {
            $file_parts = explode('.', $file);
            $_file = $extension ? $file : $file_parts[0];
            $file_path = $path ? $start . '/' . $_file : $_file;

            if (is_dir($file_path)) 
            {
              $files = array_merge($files, self::get_directory_list($file_path));
            } 
            else 
            {
              array_push($files, $file);
            }
          }
        }
      }

      closedir($file_handle);
    } 
    else 
    {
      $files = array();
    }

    return $files;
  }
}