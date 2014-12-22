<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dropbox extends CI_Controller
{
    public function __construct()
    {
    	parent::__construct();
      $this->load->library('session');
      $this->load->helper('url');
      ini_set('display_errors', true);
      error_reporting(E_ALL);      
    }
    
    // Call this method first by visiting http://SITE_URL/example/request_dropbox
    public function index()
	{
    session_start();
	  $this->load->library('dropbox_lib');
    $info = $this->dropbox_lib->getAppConfig();
    $client = $this->dropbox_lib->getClient();
    if ($client === false or true) {
      $authorizeUrl = $this->dropbox_lib->getWebAuth()->start();
      // echo $authorizeUrl;
      header("Location: $authorizeUrl");
        exit;
    }else{
      
    }
	}
  

  public function download($value='')
  {
    $debug = false;
    if(isset($_GET['challenge'])){
      echo $_GET['challenge'];exit;
    }
    if(isset($_GET['debug'])){
      $debug = true;
    }
    set_time_limit(60*30);
	  $this->load->library('dropbox_lib');
    $client = $this->dropbox_lib->getClient();
    if ($client === false) {
        header("Location:  /sync/dropbox");
        exit;
    }
    $cursor = null;
    $cursor_filename =  FCPATH."posts/cursor.txt";
    if(file_exists($cursor_filename)){
      $cursor = file_get_contents($cursor_filename);
    }
    if(empty($cursor)){
      $cursor = null;
    }
    $changes = $client->getDelta($cursor);
    
    if($debug){
      print_r($changes);        
    }
    
    if(!empty($changes))
    {
      foreach($changes['entries'] as $row){
        $filename = FCPATH."posts".$row[0];
        if($row[1]['is_dir'] ){
          if(!file_exists($filename)){
            mkdir($filename,0777,true);  
          }
          
        }else{
          if(!file_exists(dirname($filename))){
            mkdir(dirname($filename),0777,true);
          }
          if(!empty($row[1])){
            $fd = fopen($filename, "wb");
            $metadata = $client->getFile($row[0], $fd);
            fclose($fd); 
            print_r($metadata);                      
          }
    
        }


      }          
      $cursor = $changes['cursor'];
      if($cursor){
        $fd = fopen($cursor_filename, "wb");
        fwrite($fd,$cursor);
        fclose($fd); 
      }    
    }

  }
  public function callback($value='')
  {
	  $this->load->library('dropbox_lib');
    try {
        list($accessToken, $userId, $urlState) = $this->dropbox_lib->getWebAuth()->finish($_GET);
        // We didn't pass in $urlState to finish, and we're assuming the session can't be
        // tampered with, so this should be null.
        assert($urlState === null);
    }
    catch (dbx\WebAuthException_BadRequest $ex) {
        respondWithError(400, "Bad Request");
        // Write full details to server error log.
        // IMPORTANT: Never show the $ex->getMessage() string to the user -- it could contain
        // sensitive information.
        error_log("/dropbox-auth-finish: bad request: " . $ex->getMessage());
        exit;
    }
    catch (dbx\WebAuthException_BadState $ex) {
        // Auth session expired.  Restart the auth process.
        header("Location: ".getPath("dropbox-auth-start"));
        exit;
    }
    catch (dbx\WebAuthException_Csrf $ex) {
        respondWithError(403, "Unauthorized", "CSRF mismatch");
        // Write full details to server error log.
        // IMPORTANT: Never show the $ex->getMessage() string to the user -- it contains
        // sensitive information that could be used to bypass the CSRF check.
        error_log("/dropbox-auth-finish: CSRF mismatch: " . $ex->getMessage());
        exit;
    }
    catch (dbx\WebAuthException_NotApproved $ex) {
        echo renderHtmlPage("Not Authorized?", "Why not?");
        exit;
    }
    catch (dbx\WebAuthException_Provider $ex) {
        error_log("/dropbox-auth-finish: unknown error: " . $ex->getMessage());
        respondWithError(500, "Internal Server Error");
        exit;
    }
    catch (dbx\Exception $ex) {
        error_log("/dropbox-auth-finish: error communicating with Dropbox API: " . $ex->getMessage());
        respondWithError(500, "Internal Server Error");
        exit;
    }

    // NOTE: A real web app would store the access token in a database.
    $_SESSION['access-token'] = $accessToken;
    echo $userId,"<br/>";
    echo $urlState,"<br/>";
    echo "<a href='/sync/dropbox/download'>Download</a>";
  }
}

/* End of file example.php */
/* Location: ./application/controllers/welcome.php */