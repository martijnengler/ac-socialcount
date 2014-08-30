<?php
class AC_SocialCount
{
  protected $_url       = "";
  protected $_score     = 0;
  protected $_weighted  = true;
  protected $_response  = null;

  public function __construct($url, $weighted = true)
  {
    $this->_url       = $url;
    $this->_weighted  = $weighted;
    $this->_response  = new ACSC_Response($this->_url);
  }

  public function calculate_score()
  {
  }

  public function get_score($force_calc = false)
  {
    return $this->_score;
  }
}