<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
测试Api的curl
curl http://localhost:8080/api/images -F api_key=1234561 -F image=@1.jpeg
curl http://localhost:8080/api/articles -d api_key=1234561 -d name=test -d text=AAAA 
curl http://localhost:8080/api/articles  -F action=append -F api_key=1234561 -F image=@1.jpeg -F name=test -F text=AAAb
*/

class Api extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->library('blog_lib');    

  }
    
	public function index()
	{

    $content = file_get_contents(FCPATH.'api.md');
    $html = $this->blog_lib->markdown($content);
    echo $html;
	}
  
  public function test()
  {
    $this->check_auth();
  }
  
  private function check_auth()
  {
    $api_key = $this->input->post('api_key');
    if($this->blog_config['api'] && $this->blog_config['api_key']==$api_key)
    {
      return True;      
    }else
    {
        set_status_header(403);
        echo json_encode(array('errorMsg'=>'invalid api key'));
        exit;
    }
  }
  
  
  public function articles()
  {
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    
    if($method=='get')
    {
      $this->article_list ();
    }    
    
    if($method=='post')
    {
      $action = strtolower($this->input->post('action'));
      if($action=='append'){
        $this->article_append();
      }else{
        $this->article_post();
      }
      
    }
    
    if($method == 'put'){
      parse_str(file_get_contents("php://input"),$post_vars);
    }
  }
  
  public function article_list()    
  {
    $posts = $this->blog_lib->get_posts();
    if($posts){
      $posts = array_slice($posts,0,20);
      $articles = array();
      foreach($posts as $post){
        foreach($post as $key=>$val){

          if(!in_array($key,array('link','title','date','tags','intro'))){
            unset($post[$key]);
          }
        }
        $articles[]= $post;
        
      }

      echo json_encode($articles);
    }else{
      set_status_header(404);
      echo json_encode(array('errorMsg'=>'no article found'));
      exit;            
    }
    
  }
  
  /* 
  Post Image
  */  
  public function images()
  {
    $this->check_auth();
    if(isset($_FILES))
    {
      $image  = $_FILES['image'];

    }
    
    $link =  $this->blog_lib->image_upload($image);
    if($link)
    {
      $result['link'] = $link;
      echo json_encode($result);          
    }else{
      set_status_header(401);
      echo json_encode(array('errorMsg'=>$this->blog_lib->errorMsg()));
      exit;      
    }

  }  
  
  /* 
  Post Article
  */
  private function article_post()
  {
    $this->check_auth();
    $name = $this->input->post('name');
    $text = $this->input->post('text');
    $filename =  $this->blog_lib->write_post($name,$text);
    if($filename)
    {
      $link = $this->blog_lib->get_post_link($filename);
      $result['name']= $name;
      $result['link'] = $link;
      echo json_encode($result);            
    }else{
      set_status_header(401);
      echo json_encode(array('errorMsg'=>$this->blog_lib->errorMsg()));
      exit;            
    }
    
  }
  
  /*
  Append Text/Image to Article
  */
  
  private function article_append()
  {
    $this->check_auth();

    $name = $this->input->post('name');
    $image = null;
    if(isset($_FILES['image']))
    {
      $image  = $_FILES['image'];

    }
    $text = $this->input->post('text');
    
    $filename =  $this->blog_lib->append_post($name,$text,$image);
    if($filename){
      $link = $this->blog_lib->get_post_link($filename);
      $result['name']= $name;
      $result['link'] = $link;
      echo json_encode($result);      
    }else{
      set_status_header(401);
      echo json_encode(array('errorMsg'=>$this->blog_lib->errorMsg()));
      exit;            
    }

    
  }  
}
