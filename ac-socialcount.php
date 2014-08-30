<?php
<?php
/*
Plugin Name: AC Social Counter
Description: Uses the SharedCount.com API to define the most popular blogs of a WordPress install.

Needs a (free) API key from sharedcount.com
Version: 1.0
Author: Martijn Engler
Author URI: http://applecoach.nl/
*/

// fetch posts via Wp_Auery magic
foreach($posts as $post)
{
  $permalink = get_permalink($post);
  // $counts[$post->ID] = get_social_count($post);
}
natsort($counts);
// display first natsort
