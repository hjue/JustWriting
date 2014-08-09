<?php
class Myhook   
{
	function __construct(){
		 
	}
		
	function load_settings()
	{
    ini_set('date.timezone', 'Asia/Shanghai');	    
    include(FCPATH.'/settings.php');    
    $CI = & get_instance();
    if($blog_config['base_url']==''){
      $blog_config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'];
    }    
    $CI->blog_config= $blog_config;
  }
}
?>
