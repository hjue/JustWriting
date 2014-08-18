<link rel="stylesheet" type="text/css" href="/css/GitHub2.css">
JustWriting Api
============
### recently posted articles

    /api/articles
    
Http Method:GET
    
### Post article

    /api/articles
    

Http Method:Post

key|description
----|------
api_key|Api的密钥，在settings.php中设置
name|文章的文件名，去掉.md的部分。若文件存在，会覆盖原先的文章
text|文章的正文


    
返回信息，返回json格式


Success ，http status code = 200

    {
      "name" : "justwriting",
      "link" : "http://justwriting.sinaapp.com/"
    }
    
Failed：invalid api key ，http status code = 403

	{
	  "errorMsg" : "invalid api key"
	}


### Append  Image/Text to Article

	/api/articles
	
Content-Type:multipart/form-data  

Post parameters，PHP对PUT支持的不好，只能接着用Post了。

key|description
----|------
api_key|Api的密钥，在settings.php中设置
action|append，没有这个值就会覆盖文章。
name|文章的文件名，去掉.md的部分
text|追加的内容
image|追加的图片
    
返回信息，返回json格式，返回信息同Post Article


### Upload  Image

	/api/images
	

Post parameters

key|description
----|------
api_key|Api的密钥，在settings.php中设置
image|上传的图片
    
返回信息，返回json格式

Success ，http status code = 200

    {
      "link" : "http://justwriting.sinaapp.com/posts/images/world.png"
    }
