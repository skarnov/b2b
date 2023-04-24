<?php

namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function () {
    return view('404');
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * -------------------------------------------------------------------- 
 * We get a performance increase by specifying the default route since we don't have to scan directories. 
 * --------------------------------------------------------------------
 * Frontend Routes
 * --------------------------------------------------------------------
 */
$routes->get('/', 'Home::index');
$routes->get('/software-development', 'Home::software_development');
$routes->get('/web-development', 'Home::web_development');
$routes->get('/domain-registration', 'Home::domain_registration');
$routes->get('/hosting-package', 'Home::hosting_package');
$routes->get('/hosting-registration', 'Home::hosting_registration');
$routes->get('/about-us', 'Home::about_us');
$routes->get('/terms-and-conditions', 'Home::terms_and_conditions');
$routes->get('/privacy-policy', 'Home::privacy_policy');
$routes->get('/login', 'Home::login', ['filter' => 'userAuthCapability']);
$routes->get('/client', 'Client::index', ['filter' => 'auth']);
/**
 * --------------------------------------------------------------------
 * Backend Routes
 * --------------------------------------------------------------------
 */
$routes->get('/admin-login', 'Login::admin_login', ['filter' => 'authCapability']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'adminAuth']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}