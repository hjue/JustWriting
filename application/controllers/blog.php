<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

  var $data;
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library('blog_lib');  

  }


  public function load_common_data()
  {
    $this->lang->load('blog', $this->blog_config['language']);
    $this->load->library('twig_lib');    
    twig_extend();    
    $this->data['config'] = $this->blog_config;              
    $this->data['all_categories'] = $this->blog_lib->get_posts_categories(); 
    $this->data['all_tags'] = $this->blog_lib->get_posts_tags();    
  }
  
	public function index()
	{
    $this->posts();
	}
  
  public function posts($pageno=1)
  {
    $pageno = intval($pageno);

    $posts_per_page = $this->blog_config['posts_per_page'];
    if(empty($posts_per_page)) $posts_per_page = 10;
    
    $this->load_common_data();
    


    $posts = $this->blog_lib->get_posts();

    $offset = ($pageno-1)*$posts_per_page;
    $this->data['posts'] = array_slice($posts,$offset,$posts_per_page);
    if($pageno>1){
      $this->data['paginator']['has_previous'] = true;
      $this->data['paginator']['previous_page_url'] = "/page/".($pageno-1);
      
    }else{
      $this->data['paginator']['has_previous'] = false;
    }
    if(($offset+$posts_per_page)<count($posts)){
      $this->data['paginator']['has_next'] = true;
      $this->data['paginator']['next_page_url'] = "/page/".($pageno+1);
    }else{
      $this->data['paginator']['has_next'] = false;
    }
    
    $this->twig_lib->render("index.html",$this->data);

  }
  
  public function archive()
  {
    $this->load_common_data();

    $posts = $this->blog_lib->get_posts();
    $entries = array();
    foreach($posts as $post){
      $item=array();
      foreach(array('title','date','link','tags','author') as $row)
      {
        $item[$row]=$post[$row];
      }
      $entries[date('Y',$item['date'])][] = $item;
    }
    $this->data['entries'] = $entries;
    $this->twig_lib->render("archive.html",$this->data);
    
  }
  public function post($slug)
  {
    $slug=urldecode($slug);

    $this->load_common_data();
    $post = $this->blog_lib->get_post($slug);
    if($post===False)
    {
      show_404('Page Not Found.');
    }else{
      $this->data['post'] = $post['curr'];
      $this->data['next_post'] = $post['next'];
      $this->data['prev_post'] =  $post['prev'];

      $this->twig_lib->render("post.html",$this->data); 
    }

  }
  
  
  public function gallery()
  {
    $this->load_common_data();

    $this->twig_lib->render("gallery.html",$this->data); 


  }
  
  public function category($category)
  {
    $category = trim(urldecode($category));
    $this->load_common_data();    

    $this->data['posts'] = $this->blog_lib->get_posts_by_category($category);
    $this->twig_lib->render("tags.html",$this->data);
  }  
    
  public function tags($tag='')
  {
    $tag = trim(urldecode($tag));

    $this->load_common_data();
    if(empty($tag)){
      $this->twig_lib->render("tags_cloud.html",$this->data);           
      return ;
    }else{
      $this->data['posts'] = $this->blog_lib->get_posts_by_tag($tag);
      $this->twig_lib->render("tags.html",$this->data);           
    }
  }
  
  public function help()
  {
    echo $this->blog_lib->get_help();
  }
  
  public function feed()
  {
    $this->load_common_data();    
    $this->load->helper('xml');
    $this->load->helper('text');    
    $this->data['posts'] = $this->blog_lib->get_posts();
    $this->load->view("feed.html",$this->data); 
  }
}