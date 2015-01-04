Date: 2014-08-11
Title: JustWriting 使用指南
intro:Justwriting是一个极简开源博客系统，不同于Wordpress等传统博客系统，Justwriting没有博客后台，你只需要在你的电脑上用Markdown书写，还有比这更简单的吗。同时你不用担心你的文章丢失，因为文章就在你的电脑里。
Tags: JustWriting PHP  test
Status: public
Toc: yes
Position: 1


## JustWriting是支持Markdown的极简的博客系统。

![](https://raw.githubusercontent.com/hjue/JustWriting/develop/docs/page.png)

### Requirements

- PHP 5.3.6+


### Features

- 极简博客
- 不需要数据库
- 不需要管理后台
- 用Markdown写博客
- Twig Templates


### Install

1. 上传源代码到你的PHP空间
2. 将Markdown文档放到posts目录中

> Justwriting 支持[SAE](http://sae.sina.com.cn)云空间。SAE是Sina App Engine的简称，是新浪研发中心推出的国内首个公有云计算平台，支持PHP,MySQL,Memcached,Mail,TaskQueue,RDC（关系型数据库集群）等服务。SAE通过实名认证及开发者认证，每个月送大量云豆，对于一般的博客站点云豆完全够用，也就是说用SAE搭建博客完全免费，不需要支付费用。同时SAE还支持绑定自己的域名，只是对于没有备案的域名请求走海外中转，流量计费翻倍。

### 修改博客配置

博客配置在根目录下的settings.php中。
使用SAE搭建博客的小伙伴可以通过SAE提供的在线编辑代码的功能修改配置，或者通过SVN修改settings.php。
### 文章信息

文章头部放置头信息
Date: 2014-08-09
Title: Compile Zeal on Mac OS X
Tags: Zeal Mac
Status: public

### 文章发布

- 如果是在自己的VPS上搭建Justwriting，建议使用Dropbox来同步文章

    1. [ Create App ](https://www.dropbox.com/developers/apps)
    1. Generated access token
    1. Configure params in settings.php: `$blog_config['dropbox']['key'],$blog_config['dropbox']['secret'],$blog_config['dropbox']['access_token']`
    1. access [http://your_justwriting_site/sync/dropbox/download ](http://your_justwriting_site/sync/dropbox/download ) for syncing posts
    
- 如果在SAE上搭建Justwriting，建议使用SVN来更新文章
    Windows下SVN的使用方法点[这里](http://sae.sina.com.cn/doc/tutorial/code-deploy.html#tortoisesvn)
    Mac & Linux 下还是习惯用命令行：
    
        svn co https://svn.sinaapp.com/you_sae_name
        svn add 1/
        svn ci -m "submit code"   
        
    [详情使用方法点这里](http://sae.sina.com.cn/doc/tutorial/helloworld-for-linux-mac.html)
    
### ToDo List

- [ ] 文章列表分页
- [x] 支持微盘同步(Sina网盘) 
Vdisk暂时无法支持了，除非申请basic访问权限。Vdisk的App沙箱中的文件居然不出现在用户的微盘中，微盘为什么要这么设计？多学学Dropbox的设计吧。
[Vdisk文档参见这里](http://vdisk.weibo.com/developers/index.php?module=api&action=rights#space)

- [ ] 百度网盘

### 谁在用

  如果你使用了Justwriting，你将出现在这里。[点这里告诉我](https://github.com/hjue/JustWriting/issues/new)

### Contributors

- [xieyu33333](https://github.com/xieyu33333)

### Online Demo

[Online Demo](http://justwriting.sinaapp.com/)

## License

MIT