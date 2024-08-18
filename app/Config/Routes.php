<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');
$routes->get('/kelola-akun', 'Pages::kelolaAkun');
$routes->post('/update-akun', 'Pages::updateAkun');
$routes->get('/dashboard', 'Pages::index');
$routes->get('/daftar-material', 'Pages::daftarMaterial');
$routes->get('/daftar-material/tambah', 'Pages::tambahMaterial');
$routes->post('/daftar-material/store', 'Pages::storeMaterial');
$routes->get('/daftar-material/edit/(:num)', 'Pages::editMaterial/$1');
$routes->post('/daftar-material/update/(:num)', 'Pages::updateMaterial/$1');
$routes->get('/daftar-material/delete/(:num)', 'Pages::deleteMaterial/$1');
$routes->get('/daftar-upah', 'Pages::daftarUpah');
$routes->get('/daftar-upah/tambah', 'Pages::tambahUpah');
$routes->post('/daftar-upah/store', 'Pages::storeUpah');
$routes->get('/daftar-upah/edit/(:num)', 'Pages::editUpah/$1');
$routes->post('/daftar-upah/update/(:num)', 'Pages::updateUpah/$1');
$routes->get('/daftar-upah/delete/(:num)', 'Pages::deleteUpah/$1');
$routes->get('/daftar-alat', 'Pages::daftarAlat');
$routes->get('/daftar-alat/tambah', 'Pages::tambahAlat');
$routes->post('/daftar-alat/store', 'Pages::storeAlat');
$routes->get('/daftar-alat/edit/(:num)', 'Pages::editAlat/$1');
$routes->post('/daftar-alat/update/(:num)', 'Pages::updateAlat/$1');
$routes->get('/daftar-alat/delete/(:num)', 'Pages::deleteAlat/$1');
$routes->get('/daftar-pekerjaan', 'Pages::daftarPekerjaan');
$routes->get('/daftar-pekerjaan/tambah', 'Pages::tambahPekerjaan');
$routes->post('/daftar-pekerjaan/store', 'Pages::storePekerjaan');
$routes->get('/daftar-pekerjaan/edit/(:num)', 'Pages::editPekerjaan/$1');
$routes->post('/daftar-pekerjaan/update/(:num)', 'Pages::updatePekerjaan/$1');
$routes->get('/daftar-pekerjaan/delete/(:num)', 'Pages::deletePekerjaan/$1');
$routes->get('/daftar-pekerjaan/detail/(:num)', 'Pages::detailPekerjaan/$1');
$routes->get('/daftar-pekerjaan/detail/tambah/(:num)', 'Pages::tambahDetailPekerjaan/$1');
$routes->post('/daftar-pekerjaan/detail/store', 'Pages::storeDetailPekerjaan');
$routes->get('/daftar-pekerjaan/detail/edit/(:num)', 'Pages::editDetailPekerjaan/$1');
$routes->post('/daftar-pekerjaan/detail/update/(:num)', 'Pages::updateDetailPekerjaan/$1');
$routes->get('/daftar-pekerjaan/detail/delete/(:num)', 'Pages::deleteDetailPekerjaan/$1');

$routes->get('/daftar-rab', 'Pages::daftarRab');
$routes->get('/daftar-rab/dibuat/(:num)', 'Pages::dibuatRab/$1');
$routes->get('/daftar-rab/diperiksa/(:num)', 'Pages::diperiksaRab/$1');
$routes->get('/daftar-rab/diperiksa/(:num)/reject', 'Pages::rejectDiperiksaRab/$1');
$routes->get('/daftar-rab/diverifikasi/(:num)', 'Pages::diverifikasiRab/$1');
$routes->get('/daftar-rab/diverifikasi/(:num)/reject', 'Pages::rejectDiverifikasiRab/$1');
$routes->get('/daftar-rab/disetujui/(:num)', 'Pages::disetujuiRab/$1');
$routes->get('/daftar-rab/disetujui/(:num)/reject', 'Pages::rejectDisetujuiRab/$1');
$routes->get('/daftar-rab/tambah', 'Pages::tambahRab');
$routes->post('/daftar-rab/store', 'Pages::storeRab');
$routes->get('/daftar-rab/edit/(:num)', 'Pages::editRab/$1');
$routes->post('/daftar-rab/update/(:num)', 'Pages::updateRab/$1');
$routes->get('/daftar-rab/delete/(:num)', 'Pages::deleteRab/$1');
$routes->get('/daftar-rab/detail/(:num)', 'Pages::detailRab/$1');
$routes->get('/daftar-rab/detail/cetak/(:num)', 'CetakController::cetak/$1');
$routes->get('/daftar-rab/detail/excel/(:num)', 'CetakController::excel/$1');
$routes->get('/daftar-rab/detail/tambah/(:num)', 'Pages::tambahDetailRab/$1');
$routes->post('/daftar-rab/detail/store', 'Pages::storeDetailRab');
$routes->get('/daftar-rab/detail/edit/(:num)', 'Pages::editDetailRab/$1');
$routes->post('/daftar-rab/detail/update/(:num)', 'Pages::updateDetailRab/$1');
$routes->get('/daftar-rab/detail/delete/(:num)', 'Pages::deleteDetailRab/$1');
$routes->get('/kelola-pengguna', 'Pages::kelolaPengguna');
$routes->get('/kelola-pengguna/tambah', 'Pages::tambahPengguna');
$routes->post('/kelola-pengguna/store', 'Pages::storePengguna');
$routes->get('/kelola-pengguna/edit/(:num)', 'Pages::editPengguna/$1');
$routes->post('/kelola-pengguna/update/(:num)', 'Pages::updatePengguna/$1');
$routes->get('/kelola-pengguna/delete/(:num)', 'pages::deletePengguna/$1');

// $routes->get('/login', 'Pages::login');
$routes->get('/getdata', 'Pages::getData');
