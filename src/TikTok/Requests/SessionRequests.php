<?php

namespace TikTok\Requests;

// Exceptions
use TikTok\Core\Exceptions\TikTokException;

/**
 * All session requests
 * @NOTE Experimental features
 */
class SessionRequests
{

  // Parent instance
  private $instance = null;

  private $webId = '';
  private $ssid  = '';

  /**
   * Class constructor
   */
  public function __construct ($instance) {
    $this->instance  = $instance;
  }

  /**
   * @EXPERIMENTAL: Get SessionId
   */
  public function ssid () {
    if (!$this->webId) return false;

    $endpoint = $this->instance->endpoints->get('web.session-id');

    // Send a request to the api responsible for setting session id
    $res = $this->instance
      ->request
      ->setPostParams([
        'app_id'         => 1988,
        'user_unique_id' => $this->webId,
        'web_id'         => $this->webId
      ])
      ->call($endpoint)
      ->response();

    return $res;
  }

  /**
   * @EXPERIMENTAL: Get webid
   */
  public function webid () {
    $endpoint = $this->instance->endpoints->get('web.web-id');

    // Send a request to the api responsible for setting web id
    $res = $this->instance
      ->request
      ->setPostParams([
        'app_id'     => 1988,
        'referer'    => '',
        'url'        => 'https://www.tiktok.com/',
        'user_agent' => $this->instance->endpoints->defaultUserAgent,
        'user_unique_id' => ''
      ])
      ->call($endpoint)
      ->response();

    $this->webId = isset($res->web_id) ? $res->web_id : false;

    $this->instance->request->webId = $this->webId;

    return $this;
  }
}
