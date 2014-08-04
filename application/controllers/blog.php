<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('blog_lib');    

  }
    
	public function index()
	{

    $data['config'] = $this->blog_config;
    $this->load->library('twig_lib');    
    $data['posts'] = $this->blog_lib->get_posts();
    $this->twig_lib->render("index.html",$data); 
	}
  
  public function posts($pageno=1)
  {
    
  }
  
  public function post($slug)
  {
    $slug=urldecode($slug);
    $this->load->library('twig_lib');        
    $data['config'] = $this->blog_config;
    $post = $this->blog_lib->get_post($slug);
    if($post===False)
    {
      show_404('Page Not Found.');
    }else{
      $data['post'] = $post['curr'];
      $data['next_post'] = $post['next'];
      $data['prev_post'] =  $post['prev'];

      $this->twig_lib->render("post.html",$data); 
    }

  }
}
