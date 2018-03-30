<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'portal/home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//$route['login'] = 'login/home';

/* Pagination */
$route['admin/users/index'] = 'admin/users';
$route['admin/users/page/:num'] = 'admin/users/index/page/$1';  
$route['admin/users/:num'] = 'admin/users/index/$1';  

$route['admin/categories/index'] = 'admin/categories';
$route['admin/categories/:num'] = 'admin/categories/index/$1';

$route['admin/menus/index'] = 'admin/menus';
$route['admin/menus/:num'] = 'admin/menus/index/$1';

$route['admin/quizs/questions/index'] = 'admin/quizs/questions';
$route['admin/quizs/questions/:num'] = 'admin/quizs/questions/index/$1';

$route['site/home/index'] = 'site/home';
$route['site/home/:num'] = 'site/home/index/$1';  

$route['site/category/index'] = 'site/category';
$route['site/category/page/:num'] = 'site/category/index/page/$1';
$route['site/category/:num'] = 'site/category/index/$1'; 
$route['site/category/(:any)'] = 'site/category/index/(:any)';  
$route['site/category/(:any)/:num'] = 'site/category/index/(:any)/$1'; 

$route['site/archive/index'] = 'site/archive';
$route['site/archive/full'] = 'site/archive/full';
$route['site/archive/:num'] = 'site/archive/index/$1'; 
$route['site/archive/(:any)'] = 'site/archive';  

$route['(:any)-(:num)\.html'] = 'site/blog/detail/(:any)/$1';

$route['site/tag/index'] = 'site/tag';
$route['site/tag/full'] = 'site/tag/full';
$route['site/tag/:num'] = 'site/tag/index/$1';
$route['site/tag/(:any)'] = 'site/tag/index/(:any)';  

// portal

$route['portal/home/index'] = 'portal/home';
$route['portal/home/:num'] = 'portal/home/index/$1';  

$route['portal/category/index'] = 'portal/category';
$route['portal/category/page/:num'] = 'portal/category/index/page/$1';
$route['portal/category/:num'] = 'portal/category/index/$1'; 
$route['portal/category/(:any)'] = 'portal/category/index/(:any)';  
$route['portal/category/(:any)/:num'] = 'portal/category/index/(:any)/$1'; 

$route['portal/archive/index'] = 'portal/archive';
$route['portal/archive/full'] = 'portal/archive/full';
$route['portal/archive/:num'] = 'portal/archive/index/$1'; 
$route['portal/archive/(:any)'] = 'portal/archive';  

$route['(:any)-(:num)\.html'] = 'portal/blog/detail/(:any)/$1';

$route['portal/tag/index'] = 'portal/tag';
$route['portal/tag/full'] = 'portal/tag/full';
$route['portal/tag/:num'] = 'portal/tag/index/$1';
$route['portal/tag/(:any)'] = 'portal/tag/index/(:any)';  


/*
| -------------------------------------------------------------------------
| REST API Routes
| -------------------------------------------------------------------------
*/

$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8

$route['api/quiz/tests/(:num)'] = 'api/quiz/tests/id/$1'; // Example 4
$route['api/quiz/tests/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/quiz/tests/id/$1/format/$3$4'; // Example 8

$route['api/quiz/infotest/(:num)'] = 'api/quiz/infotest/id/$1'; // Example 4
$route['api/quiz/infotest/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/quiz/infotest/id/$1/format/$3$4'; // Example 8