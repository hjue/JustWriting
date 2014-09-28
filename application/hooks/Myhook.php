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
      $schema = 'http';
      if(isset($_SERVER['HTTPS']))
      {
        $schema = 'https';
      }
      $blog_config['base_url'] = $schema.'://'.$_SERVER['HTTP_HOST'];
    }    
    $CI->blog_config= $blog_config;
  }
}
?>
