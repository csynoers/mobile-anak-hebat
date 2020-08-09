<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
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
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->resource('slide');
// Equivalent to the following:
// $routes->get('slide/new',                'slide::new');
// $routes->post('slide/create',            'slide::create');
// $routes->post('slide',                   'slide::create');   // alias
// $routes->get('slide',                    'slide::index');
// $routes->get('slide/show/(:segment)',    'slide::show/$1');
// $routes->get('slide/(:segment)',         'slide::show/$1');  // alias
// $routes->get('slide/edit/(:segment)',    'slide::edit/$1');
// $routes->post('slide/update/(:segment)', 'slide::update/$1');
// $routes->get('slide/remove/(:segment)',  'slide::remove/$1');
// $routes->post('slide/delete/(:segment)', 'slide::update/$1');

$routes->resource('books');
// Equivalent to the following:
// $routes->get('books/new',                'books::new');
// $routes->post('books/create',            'books::create');
// $routes->post('books',                   'books::create');   // alias
// $routes->get('books',                    'books::index');
// $routes->get('books/show/(:segment)',    'books::show/$1');
// $routes->get('books/(:segment)',         'books::show/$1');  // alias
// $routes->get('books/edit/(:segment)',    'books::edit/$1');
// $routes->post('books/update/(:segment)', 'books::update/$1');
// $routes->get('books/remove/(:segment)',  'books::remove/$1');
// $routes->post('books/delete/(:segment)', 'books::update/$1');

$routes->resource('penerbit');
// Equivalent to the following:
// $routes->get('penerbit/new',                'penerbit::new');
// $routes->post('penerbit/create',            'penerbit::create');
// $routes->post('penerbit',                   'penerbit::create');   // alias
// $routes->get('penerbit',                    'penerbit::index');
// $routes->get('penerbit/show/(:segment)',    'penerbit::show/$1');
// $routes->get('penerbit/(:segment)',         'penerbit::show/$1');  // alias
// $routes->get('penerbit/edit/(:segment)',    'penerbit::edit/$1');
// $routes->post('penerbit/update/(:segment)', 'penerbit::update/$1');
// $routes->get('penerbit/remove/(:segment)',  'penerbit::remove/$1');
// $routes->post('penerbit/delete/(:segment)', 'penerbit::update/$1');

$routes->resource('news');
// Equivalent to the following:
// $routes->get('news/new',                'news::new');
// $routes->post('news/create',            'news::create');
// $routes->post('news',                   'news::create');   // alias
// $routes->get('news',                    'news::index');
// $routes->get('news/show/(:segment)',    'news::show/$1');
// $routes->get('news/(:segment)',         'news::show/$1');  // alias
// $routes->get('news/edit/(:segment)',    'news::edit/$1');
// $routes->post('news/update/(:segment)', 'news::update/$1');
// $routes->get('news/remove/(:segment)',  'news::remove/$1');
// $routes->post('news/delete/(:segment)', 'news::update/$1');

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
