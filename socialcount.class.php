<?php
class AC_SocialCount
{
  protected $_url   = "";
  protected $_score = 0;

  public function __construct($url)
  {
    $this->_url = $url;
  }

  public function calculate_score()
  {
  }

  public function get_score($weighted = true, $force_calc = false)
  {
    return $this->_score;
  }
}
