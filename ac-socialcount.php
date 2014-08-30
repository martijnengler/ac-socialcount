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

register_activation_hook( __FILE__, function(){
  global $wpdb;

  $charset_collate = '';

  if(!empty($wpdb->charset))
  {
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
  }

  if(!empty($wpdb->collate))
  {
    $charset_collate .= " COLLATE {$wpdb->collate}";
  }

  $sql = "CREATE TABLE wp_acsc_posts (
            acsc_id bigint(11) unsigned NOT NULL AUTO_INCREMENT,
            url varchar(200) NOT NULL DEFAULT '',
            stumbleupon int(11) NOT NULL,
            reddit int(11) NOT NULL,
            facebook_commentsbox int(11) NOT NULL,
            facebook_click int(11) NOT NULL,
            facebook_comment int(11) NOT NULL,
            facebook_like int(11) NOT NULL,
            facebook_share int(11) NOT NULL,
            delicious int(11) NOT NULL,
            googleplus int(11) NOT NULL,
            buzz int(11) NOT NULL,
            twitter int(11) NOT NULL,
            digg int(11) NOT NULL,
            pinterest int(11) NOT NULL,
            linkedin int(11) NOT NULL,
            raw_data text NOT NULL,
            PRIMARY KEY (acsc_id),
            UNIQUE KEY url (url)
          ) $charset_collate";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
});