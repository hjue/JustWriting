<?php
class Myhook   
{
	function __construct(){
		 
	}
		
	function load_settings()
	{
    if(!ini_get('date.timezone')){
      ini_set('date.timezone', 'Asia/Shanghai');        
    }    
    include(APPPATH.'../settings.php');    
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
