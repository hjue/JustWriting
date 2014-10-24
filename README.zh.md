JustWriting
============

![](https://raw.githubusercontent.com/hjue/JustWriting/develop/docs/page.png)

![](https://raw.githubusercontent.com/hjue/JustWriting/develop/docs/preview_deepure.png)

[Justwriting](https://github.com/hjue/JustWriting)是一个极简开源博客系统，不同于Wordpress等传统博客系统，Justwriting没有博客后台，你只需要在你的电脑上用Markdown书写，还有比这更简单的吗。同时你不用担心你的文章丢失，因为文章就在你的电脑里。

这个方法搭建的博客还有一个优势，就是可以用作团队博客。具体操作是把Dropbox中的文章目录共享给你的团队成员，团队成员的Dropbox中就多了你分享的目录，他只需要在这个目录中添加Markdown文章即可。当然，他也可以修改你的文章，不过这个操作最好不要和你同时进行，否则文件会出现冲突。

Justwriting的创意来自[Farbox](https://www.farbox.com/),我自己原本也是Farbox的粉丝，只是最近喜欢折腾，写了这个博客系统。

Justwriting是用Dropbox来同步文章。如果自己有VPS或者虚拟主机，建议你使用Dropbox+Justwriting，在设置博客系统以后，你只需要用Markdown书写，完全不需要关注其他。

如果你不用Dropbox，目前只能通过FTP、SVN、Git等其他途径发布文章了，这样不能发挥Justwriting最大的功效。

[在线演示在这里。](http://justwriting.sinaapp.com/)

使用当中有任何问题，[点这里告诉我](https://github.com/hjue/JustWriting/issues/new)

其他网盘的支持我正在推进中，微博微盘(Vdisk)无法支持了，因为Vdisk App沙箱中的文件居然不出现在用户的微盘中的，My God！[这是Vdisk的文档](http://vdisk.weibo.com/developers/index.php?module=api&action=rights#space)

目前已经尝试了以下的国内云盘，Justwriting都无法支持。试了一圈国内的网盘，发自内心感叹Dropbox的牛X。Dropbox不仅可以在服务器上通过客户端同步，同时也可以选择创建应用同步，Dropbox在创建应用时就可以为自己生成access token。

云盘|无法支持的原因
----|----
酷盘 [文档](http://open.kanbox.com/)|无增量接口
百度PCS [文档](http://developer.baidu.com/wiki/index.php?title=docs/pcs/rest/file_data_apis_list#.E5.A2.9E.E9.87.8F.E6.9B.B4.E6.96.B0.E6.9F.A5.E8.AF.A2) |有增量接口，但申请一周后仍未有进展
快盘 [文档](http://www.kuaipan.cn/developers/document.htm) |无增量接口
新浪微盘 [文档](http://vdisk.weibo.com/developers/index.php?module=api&action=apidoc#delta) |有增量接口，但应用的沙箱的文件不出现的用户网盘中


### Requirements

- PHP 5.3.6+


### Features

- 极简博客，全部代码不超过400行
- 不需要数据库
- 不需要用在线编辑器，只需要在本地书写
- 用Markdown书写
- 支持代码高亮
- 支持数学公式显示
- 多模板支持
- 支持使用Dropbox发布文章
- 支持通过Api发布文章


### 安装

1. 设置博客参数，修改settings.php
1. 上传源代码到你的PHP空间
2. 将Markdown文档放到posts目录中
1. 设置posts和application/cache目录web用户可写


> Justwriting 支持[SAE](http://sae.sina.com.cn)云空间。SAE是Sina App Engine的简称，是新浪研发中心推出的国内首个公有云计算平台，支持PHP,MySQL,Memcached,Mail,TaskQueue,RDC（关系型数据库集群）等服务。SAE通过实名认证及开发者认证，每个月送大量云豆，对于一般的博客站点云豆完全够用，也就是说用SAE搭建博客完全免费，不需要支付费用。同时SAE还支持绑定自己的域名，只是对于没有备案的域名请求走海外中转，流量计费翻倍。

#### Web服务器配置

* [Apache配置](https://gist.github.com/hjue/4da6b1e897de31d135f7)
* [Nginx配置](https://gist.github.com/hjue/647dc694dc3b67994202)

### 修改博客配置

博客配置在根目录下的settings.php中。
使用SAE搭建博客的小伙伴可以通过SAE提供的在线编辑代码的功能修改配置，或者通过SVN修改settings.php。

### 写文章

#### 文章头部放置头信息

文章头部放置头信息，Justwriting采用的Farbox头部信息的格式，同时也支持Jekyll的头信息格式。

    Date: 2014-08-09
    Title: 文章标题
    Intro: 文章摘要
    Tags: Justwriting Blog
    Status: public
    
    这里写正文

文章完成之前status可以设置为draft，这样这篇文章不会出现在你的博客列表中。

在posts目录中用Markdown书写，保存为.md文件。

### 文章发布

- 如果是在自己的VPS上搭建Justwriting，建议使用Dropbox来同步文章。[安装过程见这里](https://github.com/hjue/JustWriting/wiki/%E4%BD%BF%E7%94%A8Dropbox%E5%92%8CJustwriting%E6%90%AD%E5%BB%BA%E4%B8%AA%E4%BA%BA%E5%8D%9A%E5%AE%A2)。

- 虚拟主机用户按照如下指示进行操作  

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

### Api


Justwriting支持通过Api发布文章。点这里查看[Api文档](https://github.com/hjue/JustWriting/wiki/API)

使用Api需要在配置文件(settings.php)中打开Api，并且设置Api的密钥。
    
### ToDo List

- [x] 支持微盘同步(Sina网盘) 
Vdisk暂时无法支持了，除非申请basic访问权限。Vdisk的App沙箱中的文件居然不出现在用户的微盘中。
[Vdisk的文档](http://vdisk.weibo.com/developers/index.php?module=api&action=rights#space)

- [ ] 百度网盘
- [ ] 支持插件机制

### 谁在用

  如果你使用了Justwriting，你将出现在这里。[点这里告诉我](https://github.com/hjue/JustWriting/issues/new)

* [hjue](http://www.hjue.me)
* [JellyBool](http://www.jellybool.com/)
* [Colin](http://doc.mekesim.com/)
* [周渊](http://blog.zhouyuan11.cn/)

### Contributors

- [xieyu33333](https://github.com/xieyu33333)


## License

MIT