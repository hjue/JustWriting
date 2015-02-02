<?php
require APPPATH.'third_party/Michelf/MarkdownExtra.inc.php';
use \Michelf\MarkdownExtra;
define('IMAGE_PATH','posts/images/');
class blog_lib{

  var $_error;
	var $CI;
  var $posts_path;
  var $file_ext='.md';
  
  var $_all_posts;
  var $_all_tags;
  var $_all_categories;
  
	public function __construct()
	{
 
		if (!isset($this->CI))
		{
			$this->CI =& get_instance();
		}
    $this->posts_path = APPPATH.'../posts/';

	}

  public function errorMsg(){
    return $this->_error;
  }
  
  public function get_help()
  {
    $content = file_get_contents(FCPATH.'README.md');
    $html = $this->markdown($content);
    return $html;
  }
  
  public function markdown($value='')
  {        
    $text = $value;
    $html = MarkdownExtra::defaultTransform($text);
    $html = preg_replace('/<img src="images\/([^\"]*)"/i', '<img src="/posts/images/$1"', $html);
    return $html;
  }

  public function get_post_link($filename)
  {
    if(substr($filename,-3)!='.md'){
      $filename .= '.md';
    }

    $path = $this->posts_path.$filename;
    if(s_file_exists($path)){
      $slug = str_replace($this->file_ext,'',$filename);
      return $this->CI->blog_config['base_url']."/post/$slug";
    }    
  }
  
  public function write_post($filename,$text)
  {
    if(strlen(trim($text))==0) return false;
    if(substr($filename,-3)!='.md'){
      $filename .= '.md';
    }
    if(IS_SAE){
      $path = 'posts/'.$filename;
    }else{
      $path = $this->posts_path.$filename;
    }    
    if(s_write($path,"\n".$text)===false)
    {
      $this->_error = 'failed to write';
      return false;
    }else{
      return $filename;
    }
    
  }
  
  public function image_upload($image)
  {
    if(empty($image))
      return false;		
	
		if (IS_SAE)
		{
			$config['upload_path'] = IMAGE_PATH;
		}
		else
		{
      $config['upload_path'] = FCPATH.IMAGE_PATH;

      if(!file_exists($config['upload_path']))
      {       
        if(is_writable($this->posts_path)){
          mkdir($config['upload_path'],0777,true);
        }else{
          $this->_error = $config['upload_path'].' is not writable.';
          return false;
        }
       
      }
		}

    //TODO:SAE下如何获得上传文件的类型
    $config['allowed_types'] = '*';

    // $config['allowed_types'] = 'gif|jpg|png';

    
    $config['max_size'] = '0';
    $config['max_width'] = '0';
    $config['max_height'] = '0';
    $config['overwrite'] = true;

    $this->CI->load->library('upload', $config);      
    if ( !$this->CI->upload->do_upload('image'))
    {
     $this->_error = array('error' => $this->CI->upload->display_errors());
     return false;
    } 
    else
    {
     $data = $this->CI->upload->data();
     $image_filename = $data['file_name'];
     if(IS_SAE)
     {
       $link =  $data['full_path'];
     }else{
      $link = $this->CI->blog_config['base_url']."/posts/images/$image_filename";       
     }
      
     return $link;
    }     
  }
  
  public function append_post($filename,$text,$image)
  {
    if(empty($text) and empty($image)) return false;
    if(substr($filename,-3)!='.md'){
      $filename .= '.md';
    }
    if(IS_SAE){
      $path = 'posts/'.$filename;
    }else{
      $path = $this->posts_path.$filename;
    }
    
    if(!s_file_exists($path))
    {
      $this->_error = $filename.' is not exist';
      return false;
    }
    
    $content = s_read($path);
    
    if($text){
      $content .= "\n\n".$text;      
      if(s_write($path,$content)===false)
      {
        $this->_error = 'failed to write';
        return false;
      }
    }
    
    if($image){

      $ret = $this->image_upload($image);
      if($ret===false){
        return false;
      }else{
        $image_filename = basename($ret);
        $content .= "\n\n"."![](images/$image_filename)";
        if(s_write($path,$content)===false)
        {
          $this->_error = 'failed to write';
          return false;
        }else{
          return $filename;
        }      
      }
    }    
    
    return $filename;
  }  
  
  
  public function get_post($filename)
  {
    $prev_post = array();
    $next_post = array();
    $current_post = array();
    $filename .= '.md';
    $posts = $this->__get_all_posts();
    foreach($posts as $key =>$post){
      if(strtolower($post['fname'])==strtolower($filename)){
        if($key>=1)
        {
          $prev_post = $posts[$key-1];
        }
        if($key<count($posts)-1){
          $next_post = $posts[$key+1];
        }
        $current_post = $post;
        $current_post['html'] = $this->markdown($post['content']);
        break;
      }
      
    }
    if (!empty($current_post)) {
      return array('curr'=>$current_post,'prev'=>$prev_post,'next'=>$next_post);
    }else{
      return False;
    }
  }
  

  private function findFiles($directory, $extensions = array()) {
      function glob_recursive($directory, &$directories = array()) {
          foreach(glob($directory, GLOB_ONLYDIR | GLOB_NOSORT) as $folder) {
              $directories[] = $folder;
              glob_recursive("{$folder}/*", $directories);
          }
      }
      glob_recursive($directory, $directories);
      $files = array ();
      $category = array();
      foreach($directories as $directory) {
          foreach($extensions as $extension) {
              foreach(glob("{$directory}/*.{$extension}") as $file) {

                if(basename($directory)!='posts'){
                  if(array_key_exists(basename($directory),$category)){
                    $category[basename($directory)] = $category[basename($directory)] + 1;
                  }else{
                    $category[basename($directory)] = 1;
                  }
                }
                  
                $files[$extension][] = $file;
              }
          }
      }
      
      return array($category,$files);
  }
  
  private function __get_all_posts()
  {
    if(isset($this->_all_posts))
    {
      return $this->_all_posts;
    }
    $all_tags = array();
    $posts_path = $this->posts_path;
    
    list($categories,$post_files) = $this->findFiles($posts_path,array('md'));
    $this->_all_categories = $categories;

    if($handle = opendir($posts_path)) {

        $files = array();
        $filetimes = array();
        
        foreach($post_files['md'] as $post_file_path){
          $entry = basename($post_file_path);
          $fcontents = file($post_file_path);

          $hi=0;
          $pattern = '/^\s*(title|author|date|position|toc|description|intro|status|toc|url|tags|category)\s*:(.*?)$/im';
          $post_title='';
          $post_intro='';
          $post_author='';
          $post_date='';
          $post_status='public'; 
          $post_tags=array();
          $position = '';
          $toc = false;
          
          if($fcontents and $fcontents[$hi] and strpos($fcontents[$hi],':')){

            while(trim($fcontents[$hi])){
              preg_match($pattern, $fcontents[$hi], $matches);
              $hi++;
            
              if(empty($matches)) break;
              else{
                switch (trim(strtolower($matches[1]))) {
                  case 'toc':
                    $tocstring = strtolower(trim($matches[2]));
                    $toc = $tocstring=='yes'?true:false;
                    break;
                  case 'position':                        
                    $position = time() - trim($matches[2]);
                    break;
                  case 'title':                  
                    $post_title = $matches[2];
                    break;
                  case 'date':
                    $post_date = trim($matches[2]);
                    break;                      
                  case 'author':
                    $post_author = trim($matches[2]);
                    break;                                      
                  case 'status':
                    $post_status = trim($matches[2]);
                    if($post_status!='public'){
                      $post_status = 'draft';
                    }
                    break;

                  case 'tags':
                  case 'category':
                    $tags = trim($matches[2]);
                    if(substr($tags,0,1)=='[') $tags = substr($tags,1);
                    if(substr($tags,-1,1)==']') $tags = substr($tags,0,-1);
                    $post_tags = preg_split('#[,\s]#',$tags, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);


                    break;
                  case 'intro':
                  case 'description':
                    $post_intro = trim($matches[2]);
                    break;
                  
                  default:
                    # code...
                    break;
                }
              }                  
            }                  
          }

          if(empty($post_title)){
            $post_title = str_replace('.md','',$entry);
          }
          
          if(strtolower($post_status)!='public'){
            continue;
          }
          foreach($post_tags as $k=>$row)
          {
            $trimed_tag = trim($row);
            if(empty($trimed_tag))
              unset($post_tags[$k]);
            else{
              if(isset($all_tags[$trimed_tag])){

                $all_tags[$trimed_tag] += 1;
              }else{
                $all_tags[$trimed_tag] = 1;
              }
            }
          }                
          if(empty($post_date))
          {
            $post_date = filemtime($post_file_path);
          }else{
            $post_date = strtotime($post_date);
          }
          if(empty($post_author)){
            $post_author = $this->CI->blog_config['author'];  
          }
          

          $post_content_md = trim(join('', array_slice($fcontents, $hi, count($fcontents))));
          $post_content = $post_content_md;

          if(empty($post_intro)){
            $post_text = strip_tags($this->markdown($post_content));
            if (function_exists('mb_substr')){
              $post_intro = mb_substr($post_text,0,200);              
            }else{
              $post_intro = substr($post_text,0,200);
            }

          }
          $slug = str_replace($this->file_ext,'',$entry);
          
          $temp_c = basename(str_replace($entry,'',$post_file_path));
          $post_category = '';
          if($temp_c!='posts'){
            $post_category = $temp_c;
          }
          
          if($post_status=='public'){

            $files[] = array('fname' => $entry, 
            'slug'=>$slug,
            'toc'=>$toc,
            'link'=> $this->CI->blog_config['base_url']."/post/$slug",
            'title' => $post_title, 'author' => $post_author, 'date' => $post_date, 'tags' => $post_tags, 'status' => $post_status, 'intro' => $post_intro, 'content' => $post_content,'category'=>$post_category);
            if($position){
              $post_dates[] = $position;
            }else{
              $post_dates[] = $post_date;                    

            }
            
            $post_titles[] = $post_title;
            $post_authors[] = $post_author;
            $post_tags[] = $post_tags;
            $post_statuses[] = $post_status;
            $post_intros[] = $post_intro;
            $post_contents[] = $post_content;                  
          }
      }
        
        //
        array_multisort($post_dates, SORT_DESC, $files);

        $this->_all_posts = $files;
        $this->_all_tags = $all_tags;

        return $this->_all_posts;

    } else {
      $this->_all_tags = array();
      $this->_all_categories = array();
      $this->_all_posts = array();      
      return array();
    }        
  }
  

  public function get_posts($options = array())
  {
    return $this->__get_all_posts();
  }
 
  public function get_posts_tags()
  {
    $this->__get_all_posts();
    return $this->_all_tags;
  }
  
  public function get_posts_by_tag($tag){
   $tag = trim($tag);
   $posts = $this->__get_all_posts();
   $result = array();

   foreach($posts as $post)
   {
     foreach($post['tags'] as $post_tag)
     {
       if(strtolower($tag)==strtolower($post_tag)){
          $result[]=$post;
          break;
       }
     }
   }
   return $result;
  }
 
  public function get_posts_categories()
  {
    $this->__get_all_posts();
    return $this->_all_categories;
  }
    
  public function get_posts_by_category($category){
   $category = trim($category);
   $posts = $this->__get_all_posts();
   $result = array();

   foreach($posts as $post)
   {

     if(strtolower($category)==strtolower($post['category'])){
        $result[]=$post;
        break;
     }     
   }

   return $result;
  }

}