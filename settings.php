<?php
//博客标题
$blog_config['title'] = 'Just Writing';
//博客副标题
$blog_config['intro'] = 'Super Simple Blog Engine';
//博客作者
$blog_config['author']='JustWriting';
//博客头像
$blog_config['avatar']= 'https://raw.githubusercontent.com/hjue/JustWriting/develop/docs/logo.png';
//博客模板,模板在templates目录下，可自己定制
$blog_config['template'] = 'rock';
//是否开启评论,关闭设置为False
$blog_config['comment'] = True;
//多说评论系统的名字，可去多说申请 http://duoshuo.com/
$blog_config['duoshuo_short_name'] = 'justwriting';
//博客的域名如 http://justwriting.sinaapp.com,末尾不需要/
$blog_config['base_url'] = '';
//你的github地址，没有可以设置为空
$blog_config['github'] = 'https://github.com/hjue/JustWriting';

$blog_config['posts_per_page'] = 10;

//是否开启通过Api发布文章功能，默认未开启,Api文档见 /api
$blog_config['api'] = False;
//api_key的密码，请不要告诉其他人
$blog_config['api_key'] = '1234561';

//有关dropgox的配置，详细配置方法见https://github.com/hjue/JustWriting
$blog_config['dropbox']['key']= '';
$blog_config['dropbox']['secret']= '';
$blog_config['dropbox']['access_token']= '';

//代码高亮的配置，不需要的话可以设置为空
$blog_config['highlight']='<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/styles/default.min.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>';
//数学公式的支持
$blog_config['mathjax']='<script type="text/javascript" src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=default">
MathJax.Hub.Config({
    tex2jax: {
         inlineMath: [ ["$","$"]]
         },
     extensions: ["jsMath2jax.js", "tex2jax.js"],
     messageStyle: "none"
 });</script>';