<?php
/*
Plugin Name: AC Social Counter
Description: Uses the SharedCount.com API to define the most popular blogs of a WordPress install.

Needs a (free) API key from sharedcount.com
Version: 1.0
Author: Martijn Engler
Author URI: http://applecoach.nl/
*/
require_once 'socialcount.class.php';
require_once 'response.class.php';
require_once 'config.php';
add_action( 'admin_menu', function(){
  add_menu_page('AC Social Counter', 'AC Social Counter', 'manage_options', 'ac-socialcount/admin.php');
});
