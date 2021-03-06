<?php
class AC_SocialCount
{
  protected $_url       = "";
  protected $_score     = 0;
  protected $_weighted  = true;
  protected $_scores    = null;

  public function __construct($post_id, $url, $weighted = true)
  {
    $this->_post_id   = $post_id;
    $this->_url       = $url;
    $this->_weighted  = $weighted;

    $response       = new ACSC_Response($this->_url);
    $this->_scores  = $response->get_response();
    $this->_scores["wp_comments"] = wp_count_comments($this->_post_id)->total_comments;
  }

  public function calculate_score()
  {
    $this->_score = array_sum($this->_scores);
  }

  public function get_score($force_uncached = false)
  {
    $this->calculate_score();
    return $this->_score;
  }
}
