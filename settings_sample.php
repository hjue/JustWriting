<?php

//template language,english, french or zh
$blog_config['language']	= 'english';

//blog title
$blog_config['title'] = 'Just Writing';
//blog sub title
$blog_config['intro'] = 'Super Simple Blog Engine';
//blog author
$blog_config['author']='JustWriting';
//"About Me" box
$blog_config['aboutme']='This is about JustWriting';
//blog avatar
$blog_config['avatar']= 'https://raw.githubusercontent.com/hjue/JustWriting/develop/docs/logo.png';

//blog template name.The template root path is /templates.You can set rock or deepure.
$blog_config['template'] = 'rock';

//If you would like that everyone comment your post,you must set this variable to True.
$blog_config['comment'] = True;
//duoshuo short name，duoshuo is the social comment system,url is  http://duoshuo.com/.
$blog_config['duoshuo_short_name'] = 'justwriting';
//disqus short name
$blog_config['disqus_short_name'] = '';

//URL to your blog root.This is your base URL,without  a trailing slash:http://justwriting.sinaapp.com
$blog_config['base_url'] = '';

$blog_config['image_prefix'] = '';

//your github url
$blog_config['github'] = 'https://github.com/hjue/JustWriting';

//other social network : twitter, facebook, rss and email. For example :
$blog_config['twitter'] = '';
//there's more supported networks, but you must add them manually to \templates\rock\base.html - names are in \templates\rock\images\social\*

//posts count of posts list
$blog_config['posts_per_page'] = 10;

//on or off API.  API doc : https://github.com/hjue/JustWriting/wiki/API .
$blog_config['api'] = False;
//api key
$blog_config['api_key'] = '1234561';

//dropbox settings,for more infomation pls see the README : https://github.com/hjue/JustWriting
$blog_config['dropbox']['key']= '';
$blog_config['dropbox']['secret']= '';
$blog_config['dropbox']['access_token']= '';

/*
 * Supports code highlightin.If you don't write code in post,set this to empty.
 * Support 49 code styles, pls see this page: https://highlightjs.org/static/test.html
 */
$blog_config['highlight']='default';

//remove comment to support Latex math equations
/*
$blog_config['mathjax']='<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=default">
MathJax.Hub.Config({
    tex2jax: {
         inlineMath: [ ["$","$"]]
         },
     extensions: ["jsMath2jax.js", "tex2jax.js"],
     messageStyle: "none"
 });</script>';
*/