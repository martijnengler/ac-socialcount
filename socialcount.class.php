<?php
class AC_SocialCount
{
  protected $_url       = "";
  protected $_score     = 0;
  protected $_weighted  = true;

  public function __construct($url, $weighted = true)
  {
    $this->_url       = $url;
    $this->_weighted  = $weighted;
  }

  public function calculate_score()
  {
  }

  public function get_score($force_calc = false)
  {
    return $this->_score;
  }
}
