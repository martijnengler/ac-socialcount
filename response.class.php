<?php
class ACSC_Response
{
  protected $_url       = "";

  public function __construct($url)
  {
    $this->_url       = $url;
  }

  protected function fetch()
  {

  }

  protected function process_response()
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
