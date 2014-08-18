<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
  
  
  public function article($action)
  {
    if($action=='post')
    {
      $this->article_post();
    }
    
    if($action == 'append'){
      $this->article_append();
    }
  }
  
  /* 
  curl http://localhost:8080/api/image -F api_key=1234561 -F image=@2.png
  */  
  public function image()
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
      echo json_encode(array('errorMsg'=>'upload failed'));
      exit;      
    }

  }  
  
  /* 
  curl http://localhost:8080/api/article/post -d api_key=1234561 -d name=test -d text=AAAA 
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
      echo json_encode(array('errorMsg'=>'post failed'));
      exit;            
    }
    
  }
  
  /*
  curl http://localhost:8080/api/article/append -F api_key=1234561 -F image=@2.png -F name=test -F text=AAAA
  */
  
  private function article_append()
  {

    $this->check_auth();

    $name = $this->input->post('name');
    if(isset($_FILES))
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
      echo json_encode(array('errorMsg'=>'append failed'));
      exit;            
    }

    
  }  
}
