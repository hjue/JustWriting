<?php
require APPPATH.'third_party/Dropbox/strict.php';
require APPPATH.'third_party/Dropbox/autoload.php';
use \Dropbox as dbx;

class Dropbox_lib{
	var $CI;
  var $redirect_uri = '/sync/dropbox/callback';
	public function __construct()
	{
 
		if (!isset($this->CI))
		{
			$this->CI =& get_instance();
		}

	}

  
  function getWebAuth()
  {
      list($appInfo, $clientIdentifier, $userLocale) = $this->getAppConfig();
      $redirectUri = $this->CI->blog_config['base_url'].$this->redirect_uri;
      $csrfTokenStore = new dbx\ArrayEntryStore($_SESSION, 'dropbox-auth-csrf-token');
      return new dbx\WebAuth($appInfo, $clientIdentifier, $redirectUri, $csrfTokenStore, $userLocale);
  }
  
  function getClient()
  {
    $access_token = '';
    if(isset($_SESSION['access-token'])) {
        $accessToken = $_SESSION['access-token'];
    }
    
    if(isset($this->CI->blog_config['dropbox']['access_token']))
    {
      $access_token = $this->CI->blog_config['dropbox']['access_token'];
    }
    if(empty($access_token)){
      return false;
    }

    list($appInfo, $clientIdentifier, $userLocale) = $this->getAppConfig();

    return new dbx\Client($access_token, $clientIdentifier, $userLocale, $appInfo->getHost());
  }

  function getAppConfig()
  {

      $key  = $this->CI->blog_config['dropbox']['key'];
      $secret = $this->CI->blog_config['dropbox']['secret'];
      if(empty($key) || empty($secret)){
        throw new Exception("Must set dropbox key and secret");
      }
      $appInfo = array('key'=>$key,'secret'=>$secret);

      try {
          $appInfo = dbx\AppInfo::loadFromJson($appInfo);
      }
      catch (dbx\AppInfoLoadException $ex) {
          throw new Exception("Unable to load \"$appInfo\": " . $ex->getMessage());
      }

      $clientIdentifier = "justwriting";
      $userLocale = null;

      return array($appInfo, $clientIdentifier, $userLocale);
  }    
}