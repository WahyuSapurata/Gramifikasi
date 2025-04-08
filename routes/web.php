<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', 'Dashboard@index')->name('home.index');

    Route::group(['prefix' => 'login', 'middleware' => ['guest'], 'as' => 'login.'], function () {
        Route::get('/login-akun', 'AuthController@index')->name('login-akun');
        Route::post('/login-proses', 'AuthController@login_proses')->name('login-proses');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin'], 'as' => 'admin.'], function () {
        Route::get('/dashboard-admin', 'Dashboard@dashboard_admin')->name('dashboard-admin');

        Route::get('/data-guru', 'DataGuru@index')->name('data-guru');
        Route::post('/add-data-guru', 'DataGuru@add')->name('add-data-guru');
        Route::post('/edit-data-guru/{params}', 'DataGuru@edit')->name('edit-data-guru');
        Route::delete('/deleted-data-guru/{params}', 'DataGuru@deleted')->name('deleted-data-guru');

        Route::get('/data-siswa', 'DataSiswaController@index')->name('data-siswa');
        Route::post('/add-data-siswa', 'DataSiswaController@add')->name('add-data-siswa');
        Route::post('/edit-data-siswa/{params}', 'DataSiswaController@edit')->name('edit-data-siswa');
        Route::delete('/deleted-data-siswa/{params}', 'DataSiswaController@deleted')->name('deleted-data-siswa');

        Route::get('/data-mapel', 'MapelController@index')->name('data-mapel');
        Route::post('/add-data-mapel', 'MapelController@add')->name('add-data-mapel');
        Route::post('/edit-data-mapel/{params}', 'MapelController@edit')->name('edit-data-mapel');
        Route::delete('/deleted-data-mapel/{params}', 'MapelController@deleted')->name('deleted-data-mapel');

        Route::get('/data-tahunajaran', 'TahunAjaranController@index')->name('data-tahunajaran');
        Route::post('/add-data-tahunajaran', 'TahunAjaranController@add')->name('add-data-tahunajaran');
        Route::post('/edit-data-tahunajaran/{params}', 'TahunAjaranController@edit')->name('edit-data-tahunajaran');
        Route::delete('/deleted-data-tahunajaran/{params}', 'TahunAjaranController@deleted')->name('deleted-data-tahunajaran');
        Route::get('/button-active/{params}', 'TahunAjaranController@update_tombol')->name('button-active');

        Route::get('/data-akademik', 'AkademikController@index')->name('data-akademik');
        Route::post('/add-data-akademik', 'AkademikController@add')->name('add-data-akademik');
        Route::post('/edit-data-akademik/{params}', 'AkademikController@edit')->name('edit-data-akademik');
        Route::delete('/deleted-data-akademik/{params}', 'AkademikController@deleted')->name('deleted-data-akademik');

        Route::get('/data-misi', 'MisiController@index')->name('data-misi');
        Route::post('/add-data-misi', 'MisiController@add')->name('add-data-misi');
        Route::post('/edit-data-misi/{params}', 'MisiController@edit')->name('edit-data-misi');
        Route::delete('/deleted-data-misi/{params}', 'MisiController@deleted')->name('deleted-data-misi');

        Route::get('/data-lencana', 'LencanaController@index')->name('data-lencana');
        Route::post('/add-data-lencana', 'LencanaController@add')->name('add-data-lencana');
        Route::post('/edit-data-lencana/{params}', 'LencanaController@edit')->name('edit-data-lencana');
        Route::delete('/deleted-data-lencana/{params}', 'LencanaController@deleted')->name('deleted-data-lencana');

        Route::get('/data-kategori', 'KategoriPembelajaranController@index')->name('data-kategori');
        Route::post('/add-data-kategori', 'KategoriPembelajaranController@add')->name('add-data-kategori');
        Route::post('/edit-data-kategori/{params}', 'KategoriPembelajaranController@edit')->name('edit-data-kategori');
        Route::delete('/deleted-data-kategori/{params}', 'KategoriPembelajaranController@deleted')->name('deleted-data-kategori');

        Route::get('/data-forum', 'ForumController@index')->name('data-forum');
        Route::post('/add-data-forum', 'ForumController@add')->name('add-data-forum');
        Route::post('/edit-data-forum/{params}', 'ForumController@edit')->name('edit-data-forum');
        Route::delete('/deleted-data-forum/{params}', 'ForumController@deleted')->name('deleted-data-forum');
    });

    Route::group(['prefix' => 'guru', 'middleware' => ['auth.guru'], 'as' => 'guru.'], function () {
        Route::get('/dashboard-guru', 'Dashboard@dashboard_guru')->name('dashboard-guru');

        Route::get('/data-soal', 'SoalGramifikasiController@index')->name('data-soal');
        Route::post('/add-data-soal', 'SoalGramifikasiController@add')->name('add-data-soal');
        Route::post('/edit-data-soal/{params}', 'SoalGramifikasiController@edit')->name('edit-data-soal');
        Route::delete('/deleted-data-soal/{params}', 'SoalGramifikasiController@deleted')->name('deleted-data-soal');

        Route::get('penilaian-gramifikasi', 'SoalGramifikasiController@penilaian')->name('penilaian-gramifikasi');

        Route::get('/data-soalpembelajaran', 'SoalPembelajaranController@index')->name('data-soalpembelajaran');
        Route::post('/add-data-soalpembelajaran', 'SoalPembelajaranController@add')->name('add-data-soalpembelajaran');
        Route::post('/edit-data-soalpembelajaran/{params}', 'SoalPembelajaranController@edit')->name('edit-data-soalpembelajaran');
        Route::delete('/deleted-data-soalpembelajaran/{params}', 'SoalPembelajaranController@deleted')->name('deleted-data-soalpembelajaran');

        Route::get('penilaian-pembelajaran', 'SoalPembelajaranController@penilaian')->name('penilaian-pembelajaran');
    });

    Route::group(['prefix' => 'siswa', 'middleware' => ['auth.siswa'], 'as' => 'siswa.'], function () {
        Route::get('/dashboard-siswa', 'Dashboard@dashboard_siswa')->name('dashboard-siswa');

        Route::get('/detail/{params}', 'GramifikasiAnswerController@detail')->name('detail');

        Route::get('/soalgramifikasi/{params}', 'GramifikasiAnswerController@soal_gramifikasi')->name('soalgramifikasi');

        Route::post('/gramifikasi-answer', 'GramifikasiAnswerController@store')->name('gramifikasi-answer');

        Route::get('/soalpembelajaran/{params}', 'PembelajaranAnswerController@soal_pembelajaran')->name('soalpembelajaran');

        Route::post('/pembelajaran-answer', 'PembelajaranAnswerController@store')->name('pembelajaran-answer');
    });

    Route::get('/logout', 'AuthController@logout')->name('logout');
});
