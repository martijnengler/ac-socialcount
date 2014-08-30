<?php
class ACSC_Response
{
  protected $_url           = "";
  protected $_raw_response  = "";
  protected $_response      = "";

  public function __construct($url)
  {
    $this->_url = $url;
    $this->fetch();
    $this->process();
  }

  protected function fetch()
  {
    $api_url  = sprintf(AC_SC_API_HOST . "?apikey=%s&url=%s", AC_SC_API_KEY, urlencode($this->_url));
    $this->_raw_response = wp_remote_get($api_url);
  }

  protected function process()
  {
  }

  public function get_response()
  {
  }

  public function get_human_error()
  {
  }

  public function get_error_code()
  {
  }
}
