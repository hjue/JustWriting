<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('s_delete'))
{
	function s_delete($path)
	{
		$_s = new SaeStorage();
		$_f = _s_get_path($path);
		return $_s->delete($_f['domain'], $_f['filename']);
	}
}

if ( ! function_exists('s_get_url'))
{
	function s_get_url($path)
	{
		$_s = new SaeStorage();
		$_f = _s_get_path($path);
		return $_s->getUrl($_f['domain'], $_f['filename']);
	}
}


if ( ! function_exists('s_read'))
{
	function s_read($path)
	{
    if(file_exists($path)){
      return file_get_contents($path);
    }else if(IS_SAE){
      if(s_file_exists($path)){
    		$_s = new SaeStorage();
    		$_f = _s_get_path($path);
    		return $_s->read($_f['domain'], $_f['filename']);        
      }
      
    }else{
      
    }
    return false;
	}
}

if ( ! function_exists('s_write'))
{
	function s_write($path, $content)
	{
    if(IS_SAE){
  		$_s = new SaeStorage();
  		$_f = _s_get_path($path);
  		return $_s->write($_f['domain'], $_f['filename'], $content);      
    }else{
      return file_put_contents($path,$content);      
    }

	}
}

if ( ! function_exists('s_file_exists'))
{
	function s_file_exists($path)
	{
    if(IS_SAE){
      $ret = file_exists($path);
      if(!$ret){
    		$_s = new SaeStorage();
        $path = str_replace(FCPATH,'',$path);
    		$_f = _s_get_path($path);
    		return $_s->fileExists($_f['domain'], $_f['filename']);        
      }
    }else{
      return file_exists($path);
    }

	}
}

if ( ! function_exists('_s_get_path'))
{
	function _s_get_path($path) 
	{
    if(substr($path,0,1)=='/'){
      $path = substr($path,1);
    }
		$s_index = strpos($path, '/');
    if($s_index===false){
      return false;
    }else{
      return array('domain'=>substr($path,0,$s_index), 'filename'=>substr($path,$s_index+1));
    }
		
	}  
}