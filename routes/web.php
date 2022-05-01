<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('resident');
});

Route::get('/sample', 'SampleController@index')->name('index');
Route::get('/sample/view', 'SampleController@view')->name('view');


Auth::routes();
Route::prefix('resident')->group(function(){
    //ROOT
    Route::get('/', 'HomeController@index')->name('resident');
    //AUTH
    Route::get('/login', 'Auth\LoginController@showLogIn')->name('resident.showLogin');
    Route::get('/register', 'Auth\RegisterController@showRegister')->name('resident.register');
    //Route::get('/reset', 'Auth\ResetPasswordController' );
    Route::post('/logout', 'Auth\LoginController@residentLogout')->name('resident.logout');

    Route::middleware('auth')->group(function(){
        //DASHBOARD

        //TRAVEL HISTORY
        Route::get('/history', 'Resident\TravelHistoryController@index')->name('travel');

        //PROFILE
        Route::prefix('/profile')->group(function(){
            Route::get('/', 'Resident\ProfileController@index')->name('profile');
            Route::get('/create', 'Resident\ProfileController@create')->name('profile.create');
            Route::post('/store', 'Resident\ProfileController@store')->name('profile.store');
            Route::put('/update/{id}', 'Resident\ProfileController@update')->name('profile.update');
            Route::put('/updatepass/{id}', 'Resident\ProfileController@updatepass')->name('profilepass.update');
        });
        //SCANNER
        Route::prefix('/scanner')->group(function(){
            Route::get('/', 'Resident\ScannerController@index')->name('scanner');
            Route::get('/{id}', 'Resident\ScannerController@hasScanned')->name('has.scanned');
            Route::get('/cam', 'Resident\ScannerController@camera')->name('camera.scanner');
            //HEALTH DECLARATION
        });
        
        Route::post('/health-form/store/{id}', 'Establishment\QrController@healthStore')->name('health.store');
    });
    //QR
    Route::get('/in/{id}', 'Establishment\QrController@in')->name('in');
    Route::get('/out/{id}', 'Establishment\QrController@out')->name('out');
});

Route::prefix('tracer')->group(function(){
    //ROOT
    Route::get('/', 'ContactTracer\ContactTracerController@index')->name('tracer');
    //AUTH
    Route::get('/login', 'Auth\ContactTracer\LoginController@showLoginForm')->name('tracer.loginForm');
    Route::post('/logged-in', 'Auth\ContactTracer\LoginController@login')->name('tracer.login');
    Route::get('register', 'Auth\ContactTracer\RegisterController@showRegister')->name('tracer.showRegister');
    Route::post('register', 'Auth\ContactTracer\RegisterController@create')->name('tracer.register');
    Route::post('/logout', 'Auth\ContactTracer\LoginController@logout')->name('tracer.logout');

    Route::middleware('auth:contact_tracer')->group(function(){
        //DASHBOARD

        //CASES
        Route::get('/cases', 'ContactTracer\Cases@index')->name('cases');
        Route::post('/cases/store', 'ContactTracer\Cases@store')->name('case.store');
        Route::put('/cases/update/{id}', 'ContactTracer\Cases@update')->name('case.update');
        //RESIDENTS
        Route::get('/residents', 'ContactTracer\Residents@index')->name('residents');
        Route::get('/resident/travel-history/{id}', 'ContactTracer\Residents@travel')->name('travel.history');
    });
});
Route::prefix('establishment')->group(function(){
    //ROOT
    Route::get('/', 'Establishment\EstablishmentController@index')->name('establishment');
    //AUTH
    Route::get('/login', 'Auth\Establishment\LoginController@showLoginForm')->name('establishment.loginForm');
    Route::post('/logged-in', 'Auth\Establishment\LoginController@login')->name('establishment.login');
    Route::get('register', 'Auth\Establishment\RegisterController@showRegister')->name('establishment.showRegister');
    Route::post('register', 'Auth\Establishment\RegisterController@create')->name('establishment.register');
    Route::post('/logout', 'Auth\Establishment\LoginController@logout')->name('establishment.logout');

   
    Route::middleware('auth:establishment')->group(function(){
        //DASHBOARD

        //VISITORS
        Route::get('/visitors', 'Establishment\Visitors@index')->name('visitors');
        
        Route::get('/visitors/printall', 'Establishment\Visitors@pdfall')->name('visitorsall.print');
        Route::get('/visitors/printNA', 'Establishment\Visitors@pdfnotallowed')->name('visitorsnotallowed.print');
        
        Route::get('/visitors/printrange', 'Establishment\Visitors@printrange')->name('visitorsrange.print');
        Route::get('/visitors/printday', 'Establishment\Visitors@printsearch')->name('visitorsday.print');
        Route::get('/visitors/printweek', 'Establishment\Visitors@printweek')->name('visitorsweek.print');
        Route::get('/visitors/printmonth', 'Establishment\Visitors@printmonth')->name('visitorsmonth.print');


        Route::get('/visitors/view', 'Establishment\Visitors@search')->name('visitors.search');
        
        Route::get('/visitors/viewrange', 'Establishment\Visitors@searchrange')->name('visitors.searchrange');
        Route::get('/visitors/viewrrole', 'Establishment\Visitors@searchrole')->name('visitors.searchrole');
        
        
        Route::get('/visitors/week', 'Establishment\Visitors@week')->name('visitors.week');
        Route::get('/visitors/viewbyweek', 'Establishment\Visitors@searchbyweek')->name('visitors.searchbyweek');
        
        Route::get('/visitors/month', 'Establishment\Visitors@month')->name('visitors.month');
        Route::get('/visitors/viewbymonth', 'Establishment\Visitors@searchbymonth')->name('visitors.searchbymonth'); 
        
        Route::get('/visitors/viewnow', 'Establishment\Visitors@searchtoday')->name('visitors.searchtoday');
        
        Route::get('/visitors/viewnotallowed', 'Establishment\Visitors@searchnotallowed')->name('visitors.searchnotallowed');
        Route::get('/detail/{id}', 'Establishment\Visitors@detail');
        Route::get('visitors/detail/{id}', 'Establishment\Visitors@detail');

        //INFORMATION
        Route::get('/information', 'Establishment\InformationController@index')->name('information');
        Route::get('/create', 'Establishment\InformationController@create')->name('information.create');
        Route::post('/store', 'Establishment\InformationController@store')->name('information.store');
        Route::put('/update/{id}', 'Establishment\InformationController@update')->name('information.update');
        Route::put('/updatepass/{id}', 'Establishment\InformationController@updatepass')->name('informationpass.update');
        Route::put('/updatestatus/{id}', 'Establishment\InformationController@updatestatus')->name('informationhdc.update');

    });
});

