JustWriting
============

![](https://raw.githubusercontent.com/hjue/JustWriting/develop/docs/page.png)

![](https://raw.githubusercontent.com/hjue/JustWriting/develop/docs/preview_deepure.png)

### Introduction

[**Justwriting**](https://github.com/hjue/JustWriting) is a simple blog platform. You just need writing content with Markdown format, upload the .md file to website, then it will show .md files as posts on your website. 

It can synchronize files to the server by Dropbox.

So don't care about lost files while the server damaged, as all files can be store on your local devices.

If share the folder in Dropbox with others, then all members can add, edit the postes.

Of cause, if you have problem to install Dropbox on servers, it also can upload files by FTP, SVN or git, any methods you can.

[Oneline Demo](http://justwriting.sinaapp.com/)

If you have any question, [click here](https://github.com/hjue/JustWriting/issues/new) to tell me.

### Requirements

- PHP 5.3.6+

### Features

- Simple blog platform
- No need database
- No need online edit, just writing locally with any device
- Writ with Markdown
- Support code highlight
- Support Latex math equation
- Multi themes
- Support update via Dropbox
- Support post via API

### Installation

1. Setting blog parameter, update 'settings.php'
2. Upload codes to php space
3. Upload Markdown files to folder 'posts'
4. Open website, just so...

#### Web Server Configuration

* [Apache Setting](https://gist.github.com/hjue/4da6b1e897de31d135f7)
* [Nginx Setting](https://gist.github.com/hjue/647dc694dc3b67994202)

### Write Articles

#### Head information

Put the head information at the beginning of the .md file.

    Date: 2014-08-09
    Title: Post tilte
    Intro: Post abstract
    Tags: Tags
    Status: public
    
    Contents

The `status` also can be define as `draft`, then this file will not appeared on the website. 

It also support Jekyll head information.

### Add Posts

As **Justwriting** will convert any .md file in the posts folder to post, so you just need upload `.md` file to the servers through any ways. Here list some methods:

#### 1. Synic with Dropbox Automatically

If running **Justwriting** on VPS, suggest to update post through Dropbox. [Installation Process](https://github.com/hjue/JustWriting/wiki/%E4%BD%BF%E7%94%A8Dropbox%E5%92%8CJustwriting%E6%90%AD%E5%BB%BA%E4%B8%AA%E4%BA%BA%E5%8D%9A%E5%AE%A2)。

#### 2. Manually Update from Dropbox

For virtual host user, it may not able to install Dropbox client, **JustWritting** provide a function to manually pull files from Dropbox.

 1. [ Create App ](https://www.dropbox.com/developers/apps)
 2. Generated access token
 3. Configure params in settings.php: 

	      $blog_config['dropbox']['key'],
	      $blog_config['dropbox']['secret'],
	      $blog_config['dropbox']['access_token']

 4. access [http://your_justwriting_site/sync/dropbox/download ](http://your_justwriting_site/sync/dropbox/download ) for syncing posts
    

#### 3. Through Api

Justwriting supports post through Api.

If use Api, it need true on the option in settings.php, and set the Api Key in it.

Click here to check the [Api documents](https://github.com/hjue/JustWriting/wiki/API)
    
### Who are using

  - [hjue](http://www.hjue.me)
  - [JellyBool](http://www.jellybool.com/)
  - [Colin](http://doc.mekesim.com/)
  
  If you are using Justwriting, and would like to list here, [click here](https://github.com/hjue/JustWriting/issues/new) tell me.

  
### Contributors

- [xieyu33333](https://github.com/xieyu33333)


## License

Please see the file called LICENSE.
