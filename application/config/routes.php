<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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

$route['default_controller'] = "start";
$route['404_override'] = '';

//$route['admin/ort/:num'] = "admin/admin_ort";
//$route['admin/ort'] = "admin/admin_ort";
//
//$route['^admin/ort/([a-z]+)/(\d+)'] = "admin/admin_ort/$1/$2";
//$route['^admin/ort/([a-z]+)$'] = "admin/admin_ort/$1";
$route['^([a-z]+)/(\d+)'] = "$1/index/$2";

// admin/ort/edit/100
$route['^admin/([a-z]+)/([a-z]+)/(\d+)'] = "admin/admin_$1/$2/$3";
// admin/ort/100 --> admin/ort/index/100
$route['^admin/([a-z]+)/:num'] = "admin/admin_$1/index/$2";
// admin/ort/index/100/orderby
$route['^admin/([a-z]+)/(index/)?:num/([a-z]+_(asc|desc|id)_?(asc|desc)?)'] = "admin/admin_$1/index/$2/$3";
// admin/ort/index/100/orderby/restofquerystring
$route['^admin/([a-z]+)/(index/)?:num/([a-z]+_(asc|desc|id)_?(asc|desc)?)/.*'] = "admin/admin_$1/index/$2/$3/$4";
// admin/ort/create
$route['^admin/([a-z]+)/([a-z]+)'] = "admin/admin_$1/$2";
// admin default
$route['^admin/([a-z]+)'] = "admin/admin_$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
