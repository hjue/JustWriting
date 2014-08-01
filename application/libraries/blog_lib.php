<?php
require APPPATH.'third_party/Michelf/Markdown.inc.php';
use \Michelf\Markdown;
class blog_lib{

	var $CI;
  var $posts_path;
  var $file_ext='.md';
  
  var $_all_posts;
	public function __construct()
	{
 
		if (!isset($this->CI))
		{
			$this->CI =& get_instance();
		}
    $this->posts_path = FCPATH.'posts/';

	}

  public function markdown($value='')
  {        
    $text = $value;
    $html = Markdown::defaultTransform($text);
    return $html;
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
  private function __get_all_posts()
  {
    if(!empty($this->_all_posts))
    {
      return $this->_all_posts;
    }

    $posts_path = $this->posts_path;
    if($handle = opendir($posts_path)) {

        $files = array();
        $filetimes = array();

        while (false !== ($entry = readdir($handle))) {
            if(substr(strrchr($entry,'.'),1)==ltrim($this->file_ext, '.')) {
                $fcontents = file($posts_path.$entry);

                $hi=0;
                $pattern = '/^\s*(title|date|position|intro|status|toc|url|tags):(.*?)$/im';
                $post_title='';
                $post_intro='';
                $post_date='';
                $post_status=''; 
                $post_tags=array();
                       
                while(trim($fcontents[$hi])){
                  preg_match($pattern, $fcontents[$hi], $matches);
                  $hi++;
                  
                  if(empty($matches)) break;
                  else{
                    switch (strtolower($matches[1])) {
                      case 'title':
                        $post_title = $matches[2];
                        break;
                      case 'date':
                        $post_date = trim($matches[2]);
                        break;                      
                      
                      case 'status':
                        $post_status = trim($matches[2]);
                        if($post_status!='public'){
                          $post_status = 'draft';
                        }
                        break;

                      case 'tags':
                        $tags = trim($matches[2]);
                        $post_tags = explode(' ',$tags);                  

                        foreach($post_tags as $k=>$row)
                        {
                          $trimed_tag = trim($row);
                          if(empty($trimed_tag))
                            unset($post_tags[$k]);
                        }
                        break;
                      case 'intro':
                        $post_intro = trim($matches[2]);
                        break;
                        
                      default:
                        # code...
                        break;
                    }
                  }                  
                }
                if(empty($post_date) or 1)
                {
                  $post_date = filemtime($posts_path.$entry);
                }
                $post_author = $this->CI->blog_config['author'];
                $post_content_md = trim(join('', array_slice($fcontents, $hi, count($fcontents) -1)));
                $post_content = $post_content_md;
                if(empty($post_intro)){
                  $post_intro = mb_substr($post_content_md,0,200);
                }
                $slug = str_replace($this->file_ext,'',$entry);
                $files[] = array('fname' => $entry, 
                'slug'=>$slug,
                'link'=> "/post/$slug",
                'title' => $post_title, 'author' => $post_author, 'date' => $post_date, 'tags' => $post_tags, 'status' => $post_status, 'intro' => $post_intro, 'content' => $post_content);
                $post_dates[] = $post_date;
                $post_titles[] = $post_title;
                $post_authors[] = $post_author;
                $post_tags[] = $post_tags;
                $post_statuses[] = $post_status;
                $post_intros[] = $post_intro;
                $post_contents[] = $post_content;
            }
        }
        array_multisort($post_dates, SORT_DESC, $files);

        $this->_all_posts = $files;
        
        return $this->_all_posts;

    } else {
        return array();
    }        
  }
  public function get_posts($options = array())
  {
    return $this->__get_all_posts();
  }
  
}