<?php
/*
 * Piklist Checker
 * Version: 0.4.1
 *
 * Verifies that Piklist is installed and activated.
 * If not, plugin will be deactivated and user will be notifed.
 *
 * Developers:
 ** Instructions on how to use this file in your plugin can be found here:
 ** http://piklist.com/user-guide/docs/piklist-checker/
 *
 * Most recent version of this file can be found here:
 * http://s-plugins.wordpress.org/piklist/assets/class-piklist-checker.php
 */

if (!class_exists('Piklist_Checker'))
{
  class Piklist_Checker
  {
    private static $plugins = array();

    public static function init()
    {
      add_action('admin_init', array('piklist_checker', 'show_message'));
    }

    public static function check($check_plugin)
    {
      global $pagenow;

      if ($pagenow == 'update.php' || $pagenow == 'update-core.php')
      {
          return true;
      }

      if (is_multisite())
      {
        if (is_plugin_active_for_network(plugin_basename($check_plugin)))
        {
          if (!is_plugin_active_for_network('piklist/piklist.php'))
          {
            self::deactivate_plugins($check_plugin, 'network');  
          }
          return true;
        }
      }

      if (!function_exists('piklist'))
      {
        self::deactivate_plugins($check_plugin, 'single');       
      }
      
      return true;
    }

    public static function deactivate_plugins($check_plugin, $type)
    {
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');

      if ($type == "single")
      {
        $plugins = get_option('active_plugins', array()); 
      }
      else
      {
        $plugins = array_flip(get_site_option('active_sitewide_plugins', array()));
      }

      define('TYPE', $type);

      foreach ($plugins as $plugin)
      {
        if (strstr($check_plugin, $plugin))
        {
          array_push(self::$plugins, $check_plugin);
          
          deactivate_plugins($plugin);
          
          return false;
        }
      }
    }

    public static function message()
    {
      ob_start();
    
        $url_install = 'plugin-install.php?tab=search&s=piklist&plugin-search-input=Search+Plugins';
        $url_activate = 'plugins.php#piklist';
        $url_proper_dashboard = TYPE == 'network' ? network_admin_url() : admin_url();
?>
 
        <h3>
          <?php _e('Piklist Required'); ?>
          <?php TYPE == 'network' ? _e('for Network Activation') : ''; ?>
        </h3>
     
        <p>

          <?php
          if (TYPE == 'network')
          {
            _e('To Network Activate a Piklist plugin, you must first Network Activate Piklist.') . PHP_EOL;
          }
          else
          {
            _e('The plugin(s) listed below require the Piklist plugin to be installed and activated.') . PHP_EOL;
          }
          ?>

          <?php _e('You can:'); ?>

          <ol>
            <?php
            $all_plugins = get_plugins();
            if (array_key_exists('piklist/piklist.php', $all_plugins))
            {
              if (TYPE == 'single')
              {
                _e(sprintf('%1$s %2$s on this site.%3$s', '<li>', '<a href="' . admin_url() . $url_activate . '">Activate Piklist</a>','</li>'));
              }
              
              if (is_multisite() && is_super_admin())
              {
                _e(sprintf('%1$s %2$s on all sites.%3$s', '<li>', '<a href="' . network_admin_url() . $url_activate . '">Network Activate Piklist</a>','</li>'));
              }
            }
            else
            {
              _e(sprintf('%1$sDownload and %2$s to run the plugin(s).%3$s', '<li>', '<a href="' . network_admin_url() . $url_install . '">Install Piklist</a>', '</li>'));
            }
              _e(sprintf('%1$sReturn to your %2$s.%3$s', '<li>', '<a href="' . $url_proper_dashboard . '">Dashboard</a>', '</li>'));
            ?>
          </ol>
        </p>


        <h4><?php _e('The following plugin(s) have been deactivated.'); ?></h4>

        <ul>
          <?php foreach(self::$plugins as $plugin): $data = get_plugin_data($plugin); ?>
            <li>
              <?php echo $data['Title']; ?>
              <br />
              <?php echo $data['Description']; ?>
            </li>
          <?php endforeach; ?>
        </ul>

  <?php
        $message = ob_get_contents();

      ob_end_clean();
    
      return $message;
    }
    
    public static function show_message()
    {
      if (!empty(self::$plugins))
      {
        wp_die(self::message());
      }
    }
  }
  
  piklist_checker::init();


/*
 * Changelog
 *
  = 0.4.1 =
 * Fixed Unterminated Comment Notice

 = 0.4.0 =
 * Multisite support

 = 0.3.0 =
 * Bugfix: deactivated plugin after Piklist was upgraded.

 = 0.2.0 =
 * Better messages when plugin is uninstalled

 = 0.1.0 =
 * Initial release
 
 */

}
?>