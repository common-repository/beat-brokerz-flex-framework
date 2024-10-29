<?php 
/*
Plugin Name: Beat Brokerz Flex Framework
Plugin URI: http://www.beatbrokerz.com/flex/plugins/wordpress
Description: The Beat Brokerz flex framework allows you to stream and license music directly on your website. 
             You must create an app in the Beat Brokerz system first, which will control the music and
	     other display settings for your site. Once you have an app configured on Beat Brokerz,
	     save the app ID to the plugin options to enable the framework on your site.
Version: 1.0
Author: Beat Brokers Global
Author URI: http://www.beatbrokerz.com/
Text Domain: bbflex
Domain Path: /lang/
*/

/*
Copyright 2014  Beat Brokers Global LLC.
*/

add_action('init', 'bbflex_init');

function bbflex_init() {

  define('BBFLEX_URL', plugins_url() . '/' . dirname(plugin_basename(__FILE__)));
  define('BBFLEX_FILE_PATH', dirname(__FILE__));

  require_once(BBFLEX_FILE_PATH.'/assets/functions/config.php');

  $options = get_option('bbflex_setting');
  if ($options['app-id'] && !is_admin()) {

    $path_match = true;
    $current_path = trim(strtok($_SERVER['REQUEST_URI'], "?#"), "/");
    if (!$current_path) {
      $current_path = "/";
    }

    if ($options['exclude-paths']) {
      $path_match = ! bbflex_match_path($current_path, $options['exclude-paths']);
    }

    if ($path_match && $options['match-mode'] > 0 && $options['match-paths']) {
      $path_match = bbflex_match_path($current_path, $options['match-paths']);
    }

    if ($path_match) {
      wp_enqueue_script('bbflex_loader', "//www.beatbrokerz.com/flex/js/flexLoader.js", array(), NULL, false);
      wp_enqueue_script('bbflex_app', "//www.beatbrokerz.com/flexstore/apps/{$options['app-id']}?pf=wp", array(), NULL, true);
    }
  
  }
  
}

function bbflex_match_path($path, $patterns) {
  static $regexps;

  if (!isset($regexps[$patterns])) {
    $regexps[$patterns] = '/^(' . preg_replace(array('/(\r\n?|\n)/', '/\\\\\*/', '/(^|\|)\\\\<front\\\\>($|\|)/'), array('|', '.*', '\1' . preg_quote('/', '/') . '\2'), preg_quote($patterns, '/')) . ')$/';
  }
  return preg_match($regexps[$patterns], $path);
}


