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
$routes->setTranslateURIDashes(true);
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

$routes->resource('authors');
// Equivalent to the following:
// $routes->get('authors/new',                'authors::new');
// $routes->post('authors/create',            'authors::create');
// $routes->post('authors',                   'authors::create');   // alias
// $routes->get('authors',                    'authors::index');
// $routes->get('authors/show/(:segment)',    'authors::show/$1');
// $routes->get('authors/(:segment)',         'authors::show/$1');  // alias
// $routes->get('authors/edit/(:segment)',    'authors::edit/$1');
// $routes->post('authors/update/(:segment)', 'authors::update/$1');
// $routes->get('authors/remove/(:segment)',  'authors::remove/$1');
// $routes->post('authors/delete/(:segment)', 'authors::update/$1');

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

$routes->resource('kategori');
// Equivalent to the following:
// $routes->get('kategori/new',                'kategori::new');
// $routes->post('kategori/create',            'kategori::create');
// $routes->post('kategori',                   'kategori::create');   // alias
// $routes->get('kategori',                    'kategori::index');
// $routes->get('kategori/show/(:segment)',    'kategori::show/$1');
// $routes->get('kategori/(:segment)',         'kategori::show/$1');  // alias
// $routes->get('kategori/edit/(:segment)',    'kategori::edit/$1');
// $routes->post('kategori/update/(:segment)', 'kategori::update/$1');
// $routes->get('kategori/remove/(:segment)',  'kategori::remove/$1');
// $routes->post('kategori/delete/(:segment)', 'kategori::update/$1');

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

$routes->resource('faqs');
// Equivalent to the following:
// $routes->get('faqs/new',                'faqs::new');
// $routes->post('faqs/create',            'faqs::create');
// $routes->post('faqs',                   'faqs::create');   // alias
// $routes->get('faqs',                    'faqs::index');
// $routes->get('faqs/show/(:segment)',    'faqs::show/$1');
// $routes->get('faqs/(:segment)',         'faqs::show/$1');  // alias
// $routes->get('faqs/edit/(:segment)',    'faqs::edit/$1');
// $routes->post('faqs/update/(:segment)', 'faqs::update/$1');
// $routes->get('faqs/remove/(:segment)',  'faqs::remove/$1');
// $routes->post('faqs/delete/(:segment)', 'faqs::update/$1');

$routes->resource('profil');
// Equivalent to the following:
// $routes->get('profil/new',                'profil::new');
// $routes->post('profil/create',            'profil::create');
// $routes->post('profil',                   'profil::create');   // alias
// $routes->get('profil',                    'profil::index');
// $routes->get('profil/show/(:segment)',    'profil::show/$1');
// $routes->get('profil/(:segment)',         'profil::show/$1');  // alias
// $routes->get('profil/edit/(:segment)',    'profil::edit/$1');
// $routes->post('profil/update/(:segment)', 'profil::update/$1');
// $routes->get('profil/remove/(:segment)',  'profil::remove/$1');
// $routes->post('profil/delete/(:segment)', 'profil::update/$1');

$routes->resource('modul');
// Equivalent to the following:
// $routes->get('modul/new',                'modul::new');
// $routes->post('modul/create',            'modul::create');
// $routes->post('modul',                   'modul::create');   // alias
// $routes->get('modul',                    'modul::index');
// $routes->get('modul/show/(:segment)',    'modul::show/$1');
// $routes->get('modul/(:segment)',         'modul::show/$1');  // alias
// $routes->get('modul/edit/(:segment)',    'modul::edit/$1');
// $routes->post('modul/update/(:segment)', 'modul::update/$1');
// $routes->get('modul/remove/(:segment)',  'modul::remove/$1');
// $routes->post('modul/delete/(:segment)', 'modul::update/$1');

$routes->resource('contact', ['controller' =>'modul::contact']);
// $routes->get('contact', 'modul::contact');

// $routes->get('ongkir', 'Ongkir::index');
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
