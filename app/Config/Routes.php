<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->match(['get', 'post'], '/forget-password', 'AuthController::forgetPassword');
$routes->match(['get', 'post'], '/reset-password', 'AuthController::resetPassword');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'authFilter']);

//dashboard route
$routes->get('/dashboard', 'DashboardController::dashboard', ['filter' => 'authFilter']);
$routes->get('/studentQuery', 'DashboardController::studentQuery', ['filter' => 'authFilter']);
$routes->get('/careerGuidence', 'DashboardController::careerGuidence', ['filter' => 'authFilter']);
$routes->get('/careerGuidence/view/(:num)', 'DashboardController::careerGuidenceView/$1', ['filter' => 'authFilter']);

// external records 
$routes->match(['get', 'post'], 'external-records', 'DashboardController::externalRecords', ['filter' => 'authFilter']);

//all wallet history
$routes->match(['get', 'post'], 'wallet-history', 'DashboardController::walletHistory', ['filter' => 'authFilter']);

//services route

$routes->match(['get', 'post'], '/category', 'CategoryController::addService', ['filter' => 'authFilter']);
$routes->get('/category/view', 'CategoryController::services', ['filter' => 'authFilter']);
$routes->get('/category/edit/(:num)', 'CategoryController::editService/$1', ['filter' => 'authFilter']);
$routes->post('/category/update/(:num)', 'CategoryController::updateData/$1', ['filter' => 'authFilter']);
$routes->get('/category/delete/(:num)', 'CategoryController::delete/$1', ['filter' => 'authFilter']);

// services Banner   

$routes->get('/service/(:num)/banner', 'ServiceBannerController::serviceBanner/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'service/addbanner/(:num)', 'ServiceBannerController::addServiceBanner/$1', ['filter' => 'authFilter']);
$routes->post('/service/editbanner', 'ServiceBannerController::update', ['filter' => 'authFilter']);
$routes->get('/service/editbanner/(:segment)/service_id/(:num)', 'ServiceBannerController::editServiceBanner/$1/$2', ['filter' => 'authFilter']);
$routes->get('deletebanner/(:segment)/service_id/(:num)', 'ServiceBannerController::delete/$1/$2', ['filter' => 'authFilter']);


// organization  

$routes->match(['get', 'post'], '/organization', 'OrganizationController::addOrganization', ['filter' => 'authFilter']);
$routes->get('/organization/view', 'OrganizationController::organization', ['filter' => 'authFilter']);
$routes->get('/organization/edit/(:num)', 'OrganizationController::editOrganization/$1', ['filter' => 'authFilter']);
$routes->post('/organization/update/(:num)', 'OrganizationController::updateData/$1', ['filter' => 'authFilter']);
$routes->get('/organization/delete/(:num)', 'OrganizationController::delete/$1', ['filter' => 'authFilter']);
$routes->get('/organization/district/(:num)', 'OrganizationController::fetchDistrict/$1', ['filter' => 'authFilter']);
$routes->get('/organization/blocks/(:num)', 'OrganizationController::fetchBlocks/$1', ['filter' => 'authFilter']);

// organization  course 

$routes->get('/organization/(:num)/course', 'OrganisationCourseController::organizationCourse/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'organization/addcourse/(:num)', 'OrganisationCourseController::addOrganizationCourse/$1', ['filter' => 'authFilter']);
$routes->post('/organization/editcourse', 'OrganisationCourseController::update', ['filter' => 'authFilter']);
$routes->get('/organization/editcourse/(:segment)/orgnization_id/(:num)', 'OrganisationCourseController::editOrganizationCourse/$1/$2', ['filter' => 'authFilter']);
$routes->get('deletecourseOrg/(:segment)/orgnization_id/(:num)', 'OrganisationCourseController::delete/$1/$2', ['filter' => 'authFilter']);

// organization Banner   

$routes->get('/organization/(:num)/banner', 'OrganizationBannerController::organizationBanner/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'organization/addbanner/(:num)', 'OrganizationBannerController::addOrganizationBanner/$1', ['filter' => 'authFilter']);
$routes->post('/organization/editbanner', 'OrganizationBannerController::update', ['filter' => 'authFilter']);
$routes->get('/organization/editbanner/(:segment)/orgnization_id/(:num)', 'OrganizationBannerController::editOrganizationBanner/$1/$2', ['filter' => 'authFilter']);
$routes->get('deletebannerOrg/(:segment)/orgnization_id/(:num)', 'OrganizationBannerController::delete/$1/$2', ['filter' => 'authFilter']);

// Route for district  

$routes->get('district', 'DistrictController::district', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addDistrict', 'DistrictController::addDistrict', ['filter' => 'authFilter']);
$routes->post('editDistrict', 'DistrictController::update', ['filter' => 'authFilter']);
$routes->get('editData/(:segment)', 'DistrictController::editDistrict/$1', ['filter' => 'authFilter']);
$routes->get('delete/(:segment)', 'DistrictController::delete/$1', ['filter' => 'authFilter']);

// Route for Blocks  

$routes->get('blocks', 'BlocksController::blocks', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addBlocks', 'BlocksController::addBlocks', ['filter' => 'authFilter']);
$routes->post('editBlocks', 'BlocksController::update', ['filter' => 'authFilter']);
$routes->get('editDataBlocks/(:segment)', 'BlocksController::editBlocks/$1', ['filter' => 'authFilter']);
$routes->get('delete/(:segment)', 'BlocksController::delete/$1', ['filter' => 'authFilter']);
$routes->post('blocks/fetchUser', 'BlocksController::fetchUser', ['filter' => 'authFilter']);

//Course Route

$routes->match(['get', 'post'], '/course', 'CourseController::addCourse', ['filter' => 'authFilter']);
$routes->get('/course/view', 'CourseController::courses', ['filter' => 'authFilter']);
$routes->get('/course/edit/(:num)', 'CourseController::editCourse/$1', ['filter' => 'authFilter']);
$routes->post('/course/update/(:num)', 'CourseController::updateData/$1', ['filter' => 'authFilter']);
$routes->get('/course/delete/(:num)', 'CourseController::delete/$1', ['filter' => 'authFilter']);

// Route for Plans  

$routes->get('plans', 'PlansController::plans', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addplans', 'PlansController::addPlans', ['filter' => 'authFilter']);
$routes->post('editplans', 'PlansController::update', ['filter' => 'authFilter']);
$routes->get('editDataplans/(:segment)', 'PlansController::editPlans/$1', ['filter' => 'authFilter']);
$routes->get('deleteplans/(:segment)', 'PlansController::delete/$1', ['filter' => 'authFilter']);
$routes->post('plan/fetchUser', 'PlansController::fetchUser', ['filter' => 'authFilter']);

// Route for States  

$routes->get('states', 'StatesController::states', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addstates', 'StatesController::addState', ['filter' => 'authFilter']);
$routes->post('editstates', 'StatesController::update', ['filter' => 'authFilter']);
$routes->get('editDatastates/(:segment)', 'StatesController::editState/$1', ['filter' => 'authFilter']);
$routes->get('deletestates/(:segment)', 'StatesController::delete/$1', ['filter' => 'authFilter']);

//Settings  Route
$routes->get('setting', 'SettingController::index', ['filter' => 'authFilter']);
$routes->Post('setting_edit', 'SettingController::edit', ['filter' => 'authFilter']);
$routes->get('setting_view/(:segment)', 'SettingController::view_edit/$1', ['filter' => 'authFilter']);

//Profile  Route
$routes->get('profile', 'ProfileController::index', ['filter' => 'authFilter']);
$routes->Post('profile_edit/(:segment)', 'ProfileController::edit/$1', ['filter' => 'authFilter']);

// Route for Commision  

$routes->get('commsion', 'CommisionController::commission', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addcommsion', 'CommisionController::addCommission', ['filter' => 'authFilter']);
$routes->post('editcommsion', 'CommisionController::update', ['filter' => 'authFilter']);
$routes->get('editDatacommsion/(:segment)', 'CommisionController::editCommission/$1', ['filter' => 'authFilter']);
$routes->get('deletecommsion/(:segment)', 'CommisionController::delete/$1', ['filter' => 'authFilter']);

// Route for Users   
$routes->get('users/(:segment)', 'UserController::user/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addusers', 'UserController::addUser', ['filter' => 'authFilter']);
$routes->post('editusers', 'UserController::update', ['filter' => 'authFilter']);
$routes->get('editDatausers/(:segment)', 'UserController::editUser/$1', ['filter' => 'authFilter']);
$routes->get('deleteusers/(:segment)', 'UserController::delete/$1', ['filter' => 'authFilter']);
$routes->post('users/fetchplan', 'UserController::fetchPlan', ['filter' => 'authFilter']);
$routes->post('user/txn-status', 'UserController::txnStatus', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/plan/(:num)', 'UserController::activePlan/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/buy-subscription/(:num)', 'UserController::renewPlan/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/initiatePaymentProcess', 'UserController::payment', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/paytmTxn-Status', 'UserController::statusCheck', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/(:num)/invoice', 'UserController::invoice/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/(:num)/invoice/view/(:num)', 'UserController::invoiceView/$1/$2', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/(:num)/wallet', 'UserController::walletHistory/$1', ['filter' => 'authFilter']);
$routes->get('user/view/(:num)', 'UserController::userView/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'user/bank_details', 'UserController::bankDetails', ['filter' => 'authFilter']);
$routes->get('user/(:num)/bank_details', 'UserController::viewBankDetails/$1', ['filter' => 'authFilter']);
$routes->get('user/commissions', 'UserController::commissions', ['filter' => 'authFilter']);


// Route for Notification
$routes->get('notification', 'NotificationController::notification', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addnotification', 'NotificationController::addNotification', ['filter' => 'authFilter']);
$routes->post('notification/fetchUser', 'NotificationController::fetchUser', ['filter' => 'authFilter']);
$routes->get('/notification/fetchNotification/(:num)', 'NotificationController::fetchNotification/$1', ['filter' => 'authFilter']);
$routes->post('markNotificationsAsRead', 'NotificationController::readNotification', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'notification/edit/(:num)', 'NotificationController::editNotification/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'notification/update/(:num)', 'NotificationController::updateNotification/$1', ['filter' => 'authFilter']);
$routes->post('notification/class', 'NotificationController::getClass', ['filter' => 'authFilter']);



// student Route
$routes->match(['get', 'post'], 'student/add', 'StudentController::addStudent', ['filter' => 'authFilter']);
$routes->get('students', 'StudentController::viewStudents', ['filter' => 'authFilter']);
$routes->get('student/view/free-students', 'StudentController::viewFreeStudent', ['filter' => 'authFilter']);
$routes->get('student/view/paid-students', 'StudentController::viewPaidStudent', ['filter' => 'authFilter']);
$routes->get('student/single/view/(:num)', 'StudentController::viewSingleData/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/edit/(:num)', 'StudentController::editData/$1', ['filter' => 'authFilter']);
$routes->post('student/txn-status', 'StudentController::txnStatus', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/buy-subscription/(:num)', 'StudentController::renewPlan/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/initiatePaymentProcess', 'StudentController::payment', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/paytmTxn-Status', 'StudentController::statusCheck', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/(:num)/invoice', 'StudentController::invoice/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/(:num)/invoice/view/(:num)', 'StudentController::invoiceView/$1/$2', ['filter' => 'authFilter']);
$routes->get('/student/district/(:num)', 'StudentController::fetchDistrict/$1', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/enquiry', 'StudentController::enquiry', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'student/enquiry/view/(:num)', 'StudentController::enquiryView/$1', ['filter' => 'authFilter']);

//Student id card
$routes->get('student/(:num)/idCard', 'StudentController::idCard/$1', ['filter' => 'authFilter']);




//Profile  Route
$routes->get('profile', 'ProfileController::index', ['filter' => 'authFilter']);
$routes->Post('profile_edit/(:segment)', 'ProfileController::edit/$1', ['filter' => 'authFilter']);


//plan expire check route

$routes->match(['get', 'post'], 'plan/check-expire', 'SubscriptionController::checkPlan');

// Route for Dashboard Banner  

$routes->get('dashboard/banner', 'DashboardBanner::dashboardBanner', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'dashboard/addbanner', 'DashboardBanner::addDashboardBanner', ['filter' => 'authFilter']);
$routes->post('dashboard/editbanner', 'DashboardBanner::update', ['filter' => 'authFilter']);
$routes->get('dashboard/editDatabanner/(:segment)', 'DashboardBanner::editDashboardBanner/$1', ['filter' => 'authFilter']);
$routes->get('dashboard/deletebanner/(:segment)', 'DashboardBanner::delete/$1', ['filter' => 'authFilter']);


// Route for  Banner  

$routes->get('banner', 'BannerController::banner', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'addbanner', 'BannerController::addBanner', ['filter' => 'authFilter']);
$routes->post('editbanner', 'BannerController::update', ['filter' => 'authFilter']);
$routes->get('editDatabanner/(:segment)', 'BannerController::editBanner/$1', ['filter' => 'authFilter']);
$routes->get('deletebanner/(:segment)', 'BannerController::delete/$1', ['filter' => 'authFilter']);

// withdraw request route

$routes->match(['get', 'post'], 'user/(:num)/withdraw-request', 'UserController::withdrawRequest/$1', ['filter' => 'authFilter']);

$routes->match(['get', 'post'], 'withdraw-request', 'UserController::withdrawRequestList', ['filter' => 'authFilter']);
$routes->match(['get', 'post'], 'withdraw-request/view/(:num)', 'UserController::withdrawRequestView/$1', ['filter' => 'authFilter']);


// terms and condition and privacy policy

$routes->get('terms-and-conditions', 'PrivacyController::termsAndConditions');
$routes->get('privacy-policy', 'PrivacyController::privacyPolicy');

// purchase history

$routes->get('purchase-history', 'PurchaseHistoryController::index', ['filter' => 'authFilter']);
$routes->get('purchase-history/(:num)', 'PurchaseHistoryController::details/$1', ['filter' => 'authFilter']);
$routes->get('purchase-history/total-purchase', 'PurchaseHistoryController::totalPurchase', ['filter' => 'authFilter']);