<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Created on 2013-10-25 by haojue
 * Twig CI Library
 *
 */
require_once APPPATH . 'third_party/Twig/Autoloader.php';

class Twig_lib {

    private $loader ;
    private $twig;
    private $_ci;

    function __construct() {
        Twig_Autoloader::register();
        $this->_ci =& get_instance();
        $this->loader = new Twig_Loader_Filesystem(APPPATH.'../templates/'.$this->_ci->blog_config['template'].'/');
        if(IS_SAE or !is_writable(APPPATH.'cache')){
          $this->twig = new Twig_Environment($this->loader, array(
          'auto_reload' => true
          ));          
        }else{
          $this->twig = new Twig_Environment($this->loader, array(
          'cache' => APPPATH.'cache',
          'auto_reload' => true
          ));                      
        }

    }

    public function render($tpl,$data,$return = FALSE) {
        $output = $this->twig->render($tpl,$data);

        $this->_ci->output->append_output($output);
        if ($return) {
            return  $output;
        }
    } 
  /**
   * __call
   * @param string $method
   * @param array $args
   * @throws Exception
  */
    public function __call($method,$args) {
        $return = call_user_func_array(array($this->twig,$method),$args);
        if ($return) {
            return $return;
        } 
    }

}