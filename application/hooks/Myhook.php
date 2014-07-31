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
    $CI->blog_config= $blog_config;
	}
}
?>
