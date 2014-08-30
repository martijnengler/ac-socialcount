<?php
$the_query = new WP_Query('post_type=post&post_status=publish&posts_per_page=50');
if($the_query->have_posts())
{
	while($the_query->have_posts())
  {
    $the_query->the_post();
    $count = new AC_SocialCount(get_the_permalink());
    $counts[get_the_ID()] = array("title" => get_the_title(), "permalink" => get_the_permalink(), "score" => $count->get_score());
  }
}

wp_reset_postdata();

uasort($counts, function($a,$b){
  $a = $a["score"];
  $b = $b["score"];
  if ($a == $b) {
      return 0;
  }
  return ($a > $b) ? -1 : 1;
});

echo "<table>";
echo '<thead><tr><th>Post title</th><th>Score</th></tr></thead><tbody>';
foreach($counts as $c)
{
  printf('<tr><td><a href="%s">%s</a></td><td>%s</td></tr>', $c["permalink"], $c["title"], $c["score"]);
}
echo '</tbody></table>';