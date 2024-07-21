<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');
$routes->get('/kelola-akun', 'Pages::kelolaAkun');
$routes->post('/update-akun', 'Pages::updateAkun');
$routes->get('/', 'Pages::index');
$routes->get('/daftar-material', 'Pages::daftarMaterial');
$routes->get('/daftar-material/tambah', 'Pages::tambahMaterial');
$routes->post('/daftar-material/store', 'Pages::storeMaterial');
$routes->get('/daftar-material/edit/(:num)', 'Pages::editMaterial/$1');
$routes->post('/daftar-material/update/(:num)', 'Pages::updateMaterial/$1');
$routes->get('/daftar-material/delete/(:num)', 'Pages::deleteMaterial/$1');
$routes->get('/daftar-pekerja', 'Pages::daftarPekerja');
$routes->get('/daftar-pekerja/tambah', 'Pages::tambahPekerja');
$routes->post('/daftar-pekerja/store', 'Pages::storePekerja');
$routes->get('/daftar-pekerja/edit/(:num)', 'Pages::editPekerja/$1');
$routes->post('/daftar-pekerja/update/(:num)', 'Pages::updatePekerja/$1');
$routes->get('/daftar-pekerja/delete/(:num)', 'Pages::deletePekerja/$1');
$routes->get('/daftar-pekerjaan', 'Pages::daftarPekerjaan');
$routes->get('/daftar-pekerjaan/tambah', 'Pages::tambahPekerjaan');
$routes->post('/daftar-pekerjaan/store', 'Pages::storePekerjaan');
$routes->get('/daftar-pekerjaan/edit/(:num)', 'Pages::editPekerjaan/$1');
$routes->post('/daftar-pekerjaan/update/(:num)', 'Pages::updatePekerjaan/$1');
$routes->get('/daftar-pekerjaan/delete/(:num)', 'Pages::deletePekerjaan/$1');
$routes->get('/daftar-pekerjaan/detail/(:num)', 'Pages::detailPekerjaan/$1');
$routes->get('/daftar-rab', 'Pages::daftarRab');
$routes->get('/daftar-rab/tambah', 'Pages::tambahRab');
$routes->post('/daftar-rab/store', 'Pages::storeRab');
$routes->get('/daftar-rab/edit/(:num)', 'Pages::editRab/$1');
$routes->post('/daftar-rab/update/(:num)', 'Pages::updateRab/$1');
$routes->get('/daftar-rab/delete/(:num)', 'Pages::deleteRab/$1');
$routes->get('/daftar-rab/view/(:num)', 'Pages::viewRab/$1');
$routes->get('/kelola-pengguna', 'Pages::kelolaPengguna');
$routes->get('/kelola-pengguna/tambah', 'Pages::tambahPengguna');
$routes->post('/kelola-pengguna/store', 'Pages::storePengguna');
$routes->get('/kelola-pengguna/edit/(:num)', 'Pages::editPengguna/$1');
$routes->post('/kelola-pengguna/update/(:num)', 'Pages::updatePengguna/$1');
$routes->get('/kelola-pengguna/delete/(:num)', 'pages::deletePengguna/$1');

// $routes->get('/login', 'Pages::login');
$routes->get('/getdata', 'Pages::getData');
