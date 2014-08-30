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
    $this->save_to_cache();
  }

  protected function fetch()
  {
    $this->_raw_response = unserialize('a:5:{s:7:"headers";a:17:{s:4:"date";s:29:"Sat, 30 Aug 2014 11:55:01 GMT";s:12:"content-type";s:16:"application/json";s:10:"connection";s:5:"close";s:10:"set-cookie";s:137:"__cfduid=d04b1c3797148bd882e160549b5ddd8a21409399701968; expires=Mon, 23-Dec-2019 23:50:00 GMT; path=/; domain=.sharedcount.com; HttpOnly";s:11:"x-memcached";s:4:"True";s:12:"x-fetch-date";s:29:"Sat, 30-Aug-2014 11:36:06 GMT";s:17:"x-quota-remaining";s:4:"9998";s:12:"x-quota-used";s:1:"2";s:27:"access-control-allow-origin";s:1:"*";s:13:"cache-control";s:20:"public, max-age=7200";s:7:"expires";s:29:"Sat, 30 Aug 2014 13:55:01 GMT";s:4:"vary";s:15:"Accept-Encoding";s:18:"alternate-protocol";s:15:"80:quic,80:quic";s:15:"cf-cache-status";s:3:"HIT";s:6:"server";s:16:"cloudflare-nginx";s:6:"cf-ray";s:20:"1620cc09413706fa-LHR";s:16:"content-encoding";s:4:"gzip";}s:4:"body";s:234:"{"StumbleUpon":0,"Reddit":0,"Delicious":0,"Pinterest":0,"Twitter":1,"Diggs":0,"LinkedIn":0,"Facebook":{"commentsbox_count":0,"click_count":0,"total_count":3,"comment_count":0,"like_count":2,"share_count":1},"GooglePlusOne":2,"Buzz":0}";s:8:"response";a:2:{s:4:"code";i:200;s:7:"message";s:2:"OK";}s:7:"cookies";a:1:{i:0;O:14:"WP_Http_Cookie":6:{s:4:"name";s:8:"__cfduid";s:5:"value";s:46:"d04b1c3797148bd882e160549b5ddd8a21409399701968";s:7:"expires";i:1577145000;s:4:"path";s:1:"/";s:6:"domain";s:16:".sharedcount.com";s:8:"httponly";s:0:"";}}s:8:"filename";N;}');
    return;
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
