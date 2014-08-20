<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends CI_Controller {

  /*
  SAE环境中，若图片不存在，则在Storage中读取
  */
	public function file($path)
	{
    if(!IS_SAE) return ;
    $this->load->helper('url');
    $file = uri_string();
    if(substr($file,0,1)=='/'){
      $file = substr($file,1);
    }
        
		$storage = new SaeStorage();

		$s_index = strpos($file, '/');
		$_f = array('domain'=>substr($file,0,$s_index), 'filename'=>substr($file,$s_index+1));

    if($storage->fileExists($_f['domain'], $_f['filename']))
    {
        header('Content-Type:image/jpeg');
        echo $storage->read($_f['domain'], $_f['filename']);
    }else{
        set_status_header(404);
    }
	}
}
