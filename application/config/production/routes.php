<?php

defined('BASEPATH') or exit('No direct script access allowed');



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



// AUTH PAGE

$route['admin'] = 'auth/controller_ctl/login';

$route['login'] = 'auth/controller_ctl/login';

$route['register'] = 'auth/controller_ctl/register';
$route['auth/(:any)'] = 'auth/controller_ctl/$1';

$route['auth/(:any)/(:any)'] = 'auth/controller_ctl/$1/$2';


$route['auth_function']  = 'auth/function_ctl';

$route['auth_function/(:any)'] = 'auth/function_ctl/$1';

$route['auth_function/(:any)/(:any)'] = 'auth/function_ctl/$1/$2';


$route['logout'] = 'auth/function_ctl/logout';

// ADMIN PAGE

$route['master'] = 'master/controller_ctl/index';

$route['master/(:any)'] = 'master/controller_ctl/$1';

$route['master/(:any)/(:any)'] = 'master/controller_ctl/$1/$2';

$route['master/(:any)/(:any)/(:any)'] = 'master/controller_ctl/$1/$2/$3';

$route['master/(:any)/(:any)/(:any)/(:any)'] = 'master/controller_ctl/$1/$2/$3/$4';

$route['master/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'master/controller_ctl/$1/$2/$3/$4/$5';

$route['master_function']  = 'master/function_ctl';

$route['master_function/(:any)'] = 'master/function_ctl/$1';

$route['master_function/(:any)/(:any)'] = 'master/function_ctl/$1/$2';


$route['download'] = 'setting/controller_ctl/download';
$route['cetak_excel'] = 'setting/controller_ctl/cetak_excel';

$route['setting']  = 'setting/controller_ctl';

$route['setting/(:any)'] = 'setting/controller_ctl/$1';

$route['setting/(:any)/(:any)'] = 'setting/controller_ctl/$1/$2';

$route['setting_function']  = 'setting/function_ctl';

$route['setting_function/(:any)'] = 'setting/function_ctl/$1';

$route['setting_function/(:any)/(:any)'] = 'setting/function_ctl/$1/$2';

$route['setting_function/(:any)/(:any)/(:any)'] = 'setting/function_ctl/$1/$2/$3';

$route['setting_function/(:any)/(:any)/(:any)/(:any)'] = 'setting/function_ctl/$1/$2/$3/$4';




$route['profile']  = 'setting/controller_ctl/profil';

$route['profile/(:any)'] = 'setting/controller_ctl/profil/$1';

$route['profile/(:any)/(:any)'] = 'setting/controller_ctl/profil/$1/$2';


$route['user']  = 'user/controller_ctl/index';

$route['user/(:any)'] = 'user/controller_ctl/$1';

$route['user/(:any)/(:any)'] = 'user/controller_ctl/$1/$2';

$route['user/(:any)/(:any)/(:any)'] = 'user/controller_ctl/$1/$2/$3';



$route['website']  = 'dashboard/controller_ctl/website';

$route['feedback']  = 'dashboard/controller_ctl/feedback';

$route['dashboard']  = 'dashboard/controller_ctl/dashboard';

$route['dashboard/(:any)'] = 'dashboard/controller_ctl/dashboard/$1';

$route['dashboard/(:any)/(:any)'] = 'dashboard/controller_ctl/dashboard/$1/$2';


$route['map'] = 'map/controller_ctl/index';

$route['map/(:any)'] = 'map/controller_ctl/$1';

$route['map/(:any)/(:any)'] = 'map/controller_ctl/$1/$2';


$route['ecommerse']  = 'ecommerse/controller_ctl/index';

$route['ecommerse/(:any)'] = 'ecommerse/controller_ctl/$1';

$route['ecommerse/(:any)/(:any)'] = 'ecommerse/controller_ctl/$1/$2';


$route['dashboard_function']  = 'dashboard/function_ctl/index';

$route['dashboard_function/(:any)'] = 'dashboard/function_ctl/$1';

$route['dashboard_function/(:any)/(:any)'] = 'dashboard/function_ctl/$1/$2';

$route['report']  = 'dashboard/controller_ctl/report';

$route['report/(:any)'] = 'dashboard/controller_ctl/report/$1';

$route['report/(:any)/(:any)'] = 'dashboard/controller_ctl/report/$1/$2';



// CETAK
$route['cetak']  = 'cetak/controller_ctl';

$route['cetak/(:any)'] = 'cetak/controller_ctl/$1';

$route['cetak/(:any)/(:any)'] = 'cetak/controller_ctl/$1/$2';

$route['import']  = 'import/controller_ctl';

$route['import/(:any)'] = 'import/controller_ctl/$1';

$route['import/(:any)/(:any)'] = 'import/controller_ctl/$1/$2';


$route['cms']  = 'cms/controller_ctl/index';

$route['cms/(:any)'] = 'cms/controller_ctl/base/$1';

$route['cms/(:any)/(:any)'] = 'cms/controller_ctl/base/$1/$2';

$route['cms_function']  = 'cms/function_ctl';

$route['cms_function/(:any)'] = 'cms/function_ctl/$1';

$route['cms_function/(:any)/(:any)'] = 'cms/function_ctl/$1/$2';


$route['basedata']  = 'basedata/controller_ctl/index';

$route['basedata/(:any)'] = 'basedata/controller_ctl/$1';

$route['basedata/(:any)/(:any)'] = 'basedata/controller_ctl/$1/$2';

$route['basedata_function']  = 'basedata/function_ctl';

$route['basedata_function/(:any)'] = 'basedata/function_ctl/$1';

$route['basedata_function/(:any)/(:any)'] = 'basedata/function_ctl/$1/$2';


$route['user_function']  = 'user/function_ctl';

$route['user_function/(:any)'] = 'user/function_ctl/$1';

$route['user_function/(:any)/(:any)'] = 'user/function_ctl/$1/$2';

// MANIPULATE PAGE

$route['cms']  = 'cms/controller_ctl/index';

$route['cms/(:any)'] = 'cms/controller_ctl/base/$1';

$route['cms/(:any)/(:any)'] = 'cms/controller_ctl/base/$1/$2';

$route['cms/(:any)/(:any)/(:any)'] = 'cms/controller_ctl/base/$1/$2/$3';

$route['cms/(:any)/(:any)/(:any)/(:any)'] = 'cms/controller_ctl/base/$1/$2/$3/$4';

require_once(BASEPATH . 'database/DB' . EXT);

// Inisialisasi database
$db =& DB();
$query = $db->query("SELECT * FROM page WHERE status = 'Y' AND type = 2 ORDER BY urutan ASC");

// Ambil hasil query
$result = $query->result();

if ($result) {
    foreach ($result as $row) {
        // Tambahkan routing dinamis berdasarkan data dari database
        $route[$row->url] = 'user/controller_ctl/base/' . $row->id_page;
    }
}
$route['detail'] = 'user/controller_ctl/index';
$route['detail/(:any)'] = 'user/controller_ctl/detail/$1';

$route['default_controller'] = 'user/controller_ctl/index';
// DEFAULT PAGE


$route['404_override'] = '';


$route['translate_uri_dashes'] = TRUE;
