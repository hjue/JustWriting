<?php
class MY_Loader extends CI_Loader {
	public function __construct()
	{
    parent::__construct();
    include(FCPATH.'/settings.php');    
    $this->_ci_view_paths = array(FCPATH.'templates/'.$blog_config['template'].'/'  => TRUE);
	}  
}