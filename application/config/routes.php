<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "blog";
$route['page/(\d+)'] = "blog/posts/$1";
$route['post/(:any)'] = "blog/post/$1";
$route['archive'] = "blog/archive";
$route['tags/(:any)'] = "blog/tags/$1";
$route['tags'] = "blog/tags";
$route['category/(:any)'] = "blog/category/$1";
$route['help'] = "blog/help";
$route['feed'] = "blog/feed";
$route['gallery'] = "blog/gallery";
$route['sync/dropbox'] = "dropbox";
$route['sync/dropbox/(:any)'] = "dropbox/$1";

$route['api'] = "api/index";

$route['images/(:any)'] = 'images/file/$1';
$route['posts/images/(:any)'] = 'images/file/$1';

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */