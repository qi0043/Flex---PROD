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

$route['sam/view/(:any)/(:any)'] = "sam/showsam/index/html/$1/$2";
$route['sam/pdf/(:any)/(:any)'] = "sam/showsam/index/pdf/$1/$2";


$route['sam/view/(:any)/(:any)'] = "sam/showsam/index/html/$1/$2";
$route['sam/pdf/(:any)/(:any)'] = "sam/showsam/index/pdf/$1/$2";



/*  routes reverted to previous :: AJC 28-07-2014

$route['map/md/topic/(:any)/(:any)'] = "som/topicdetail/index/$1/$2";


$route['map/md/fmgosearch/(:any)'] = "som/fmgosearch/index/$1";
$route['map/md/amcgosearch/(:any)'] = "som/amcgosearch/index/$1";

$route['map/md/fmgo'] = "som/fmgo/index/";
$route['map/md/amcgo'] = "som/amcgo/index/";


$route['map/md/fmgo/(:any)'] = "som/fmgolevel/index/$1";
$route['map/md/amcgo/(:any)'] = "som/amcgolevel/index/$1";


$route['map/md'] = "som/startup/index";

$route['map/md/startup'] = "som/startup/index";

*/



$route['som/topic/(:any)/(:any)'] = "som/topicdetail/index/$1/$2";
$route['som/summary/(:any)/(:any)'] = "som/topicsummary/index/$1/$2";
$route['som/lta/(:any)/(:any)/(:any)'] = "som/learningandteaching/index/$1/$2/$3";
$route['som/lta2/(:any)/(:any)/(:any)'] = "som/learningandteachingTest/index/$1/$2/$3";
$route['som/activity/(:any)/(:any)/(:any)'] = "som/activity/index/$1/$2/$3";

$route['som/summary2/(:any)/(:any)'] = "som/topicsummary2/index/$1/$2";


$route['som/cmap'] = "som/mdmaptaa2";
$route['som/maptest'] = "som/maptest/index";
//$route['som/maptest/(:any)/(:any)'] = "som/maptest/index/$1/$2";
$route['som/maptopics/(:any)'] = "som/maptopicstest/index/$1";

$route['som/fmgosearch/(:any)'] = "som/fmgosearch/index/$1";
$route['som/amcgosearch/(:any)'] = "som/amcgosearch/index/$1";

$route['som/amcgosearch_sam/(:any)'] = "som/amcgosearch_sam/index/$1";



$route['som/fmgo/(:any)'] = "som/fmgolevel/index/$1";
$route['som/amcgo/(:any)'] = "som/amcgolevel/index/$1";


$route['som'] = "som/startup/index";

$route['pbl/case/(:any)/(:any)'] = "pbl/presentation/index/$1/$2";
$route['pbl/tutor/(:any)/(:any)'] = "pbl/tutor/index/$1/$2";


$route['pbl/trigger/(:any)/(:any)'] = "pbl/trigger/index/$1/$2";


$route['pbl/handout/(:any)/(:any)/(:any)'] = "pbl/handout/index/$1/$2/$3";



$route['mymedcourse/weeklist/(:any)'] = "mymedcourse/weeklist/index/$1";
$route['mymedcourse/weekview/(:any)/(:any)/(:any)'] = "mymedcourse/weekview/index/$1/$2/$3";


$route['default_controller'] = "error_404";
$route['404_override'] = '';



/**************  ocf *********************************/
$route['ocf/topic/(:any)/(:any)'] = "ocf/topicdetail/index/$1/$2";
$route['ocf/summary/(:any)/(:any)'] = "ocf/topicsummary/index/$1/$2";
$route['ocf/lta/(:any)/(:any)/(:any)'] = "ocf/learningandteaching/index/$1/$2/$3";
$route['ocf/lta2/(:any)/(:any)/(:any)'] = "ocf/learningandteachingnew/index/$1/$2/$3";
$route['ocf/activity/(:any)/(:any)/(:any)'] = "ocf/activity/index/$1/$2/$3";

$route['ocf/summary2/(:any)/(:any)'] = "ocf/topicsummary2/index/$1/$2";


$route['ocf/cmap'] = "ocf/mdmaptaa2";
$route['ocf/map'] = "ocf/maptest/index";


//$route['ocf/maptest/(:any)/(:any)'] = "ocf/maptest/index/$1/$2";
$route['ocf/maptopics/(:any)'] = "ocf/maptopicstest/index/$1";

$route['ocf/fmgosearch/(:any)'] = "ocf/fmgosearch/index/$1";
$route['ocf/amcgosearch/(:any)'] = "ocf/amcgosearch/index/$1";

$route['ocf/amcgosearch_sam/(:any)'] = "ocf/amcgosearch_sam/index/$1";

$route['ocf/assessmentSummary/(:any)/(:any)'] = "ocf/assessmentSummary/index/$1/$2";

$route['ocf/fmgo/(:any)'] = "ocf/fmgolevel/index/$1";
$route['ocf/amcgo/(:any)'] = "ocf/amcgolevel/index/$1";


$route['ocf'] = "ocf/startup/index";
/* End of file routes.php */
/* Location: ./application/config/routes.php */


/************ RHD Theses *******************************/
$route['rhd'] = "rhd/rhdMgt/getUserGroups";

