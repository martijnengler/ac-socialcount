<?php
class ACSC_Response
{
  protected $_url             = "";
  protected $_raw_response    = "";
  protected $_response        = "";
  protected $_force_uncached  = false;

  public function __construct($url, $force_uncached = false)
  {
    $this->_url             = $url;
    $this->_force_uncached  = $force_uncached;
    $this->fetch();
  }

  protected function fetch()
  {
    if($this->_force_uncached or ($this->fetch_from_cache() and !$this->_response))
    {
      $this->fetch_from_api();
      $this->process();
      $this->save_to_cache();
    }
  }

  protected function fetch_from_cache()
  {
    global $wpdb;
    $sql = $wpdb->prepare("SELECT stumbleupon, reddit, facebook_commentsbox, facebook_click, facebook_comment, facebook_like, facebook_share, delicious, googleplus, buzz, twitter, digg, pinterest, linkedin 
                                          FROM {$wpdb->prefix}acsc_posts
                                          WHERE url = %s", $this->_url);
    if($row = $wpdb->get_row($sql, ARRAY_A))
    {
      $this->_response = $row;
    }
    return true;
  }

  protected function fetch_from_api()
  {
    $api_url  = sprintf(AC_SC_API_HOST . "?apikey=%s&url=%s", AC_SC_API_KEY, urlencode($this->_url));
    $this->_raw_response = wp_remote_get($api_url);
  }

  protected function process()
  {
    // TODO: need to do some error handling here, for now just assume everything's okay for this quick prototype
    $this->_response = json_decode($this->_raw_response["body"], true);
  }

  protected function save_to_cache()
  {
    global $wpdb;

    $wpdb->insert(
      $wpdb->prefix . 'acsc_posts',
      array(
              'url'                   => $this->_url,
              'stumbleupon'           => $this->_response['StumbleUpon'],
              'reddit'                => $this->_response['Reddit'],
              'facebook_commentsbox'  => $this->_response['Facebook']['commentsbox_count'],
              'facebook_click'        => $this->_response['Facebook']['click_count'],
              'facebook_comment'      => $this->_response['Facebook']['comment_count'],
              'facebook_like'         => $this->_response['Facebook']['like_count'],
              'facebook_share'        => $this->_response['Facebook']['share_count'],
              'delicious'             => $this->_response['Delicious'],
              'googleplus'            => $this->_response['GooglePlusOne'],
              'buzz'                  => $this->_response['Buzz'],
              'twitter'               => $this->_response['Twitter'],
              'digg'                  => $this->_response['Diggs'],
              'pinterest'             => $this->_response['Pinterest'],
              'linkedin'              => $this->_response['LinkedIn'],
              'raw_data'              => serialize($this->_raw_response)
            )
    );
  }

  public function get_response()
  {
    return $this->_response;
  }

  public function get_human_error()
  {
  }

  public function get_error_code()
  {
  }
}
