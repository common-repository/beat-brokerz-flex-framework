<?php 

  add_action('admin_menu', 'bbflex_menu');

  function bbflex_menu() { 
	add_menu_page("Beat Brokerz Flex Framework", "BB Flex", 8, __FILE__, "bbflex_setting", BBFLEX_URL.'/assets/images/bbflex.png');
  }
  
  function bbflex_setting() {
	include_once(BBFLEX_FILE_PATH.'/assets/functions/bbflex_settings.php');
  }

  function bbflex_func( $atts ) {

    $options = get_option('bbflex_setting');
    if ($options['enable-shortcodes']) {
      unset($atts[0]);
      return "<div data-bbflex=\"" . htmlentities(json_encode($atts)) . "\"></div>";
    }
    
  }
  
  add_shortcode( 'bbflex', 'bbflex_func' );
