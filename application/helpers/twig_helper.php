<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('twig_extend'))
{
  function twig_extend() 
  {
    $CI = & get_instance();
    if ( ! $CI->twig_lib instanceof Twig_lib) {
      log_message('error', "Twig library not initialized");
      return;
    }

  $lang = new Twig_SimpleFunction('lang', 'lang');

  // Now you’ll be able to use {{ base_url('something') }} in your
  // template files, after you call this twig_extend() helper function
  // in your controllers.
  $CI->twig_lib->addFunction($lang);
 }
}