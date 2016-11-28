<?php

Route::group(['middleware' => 'auth'], function(){
	Route::get('/dashboard', 'DashboardController@index');
	Route::get('dashboard/schedule/print/{id}', 'DashboardController@printSchedule');

	/** Login User's Profile **/
	Route::get('message/destroy/{message}', 'ProfileController@destroyMessage');
    Route::get('/profile', 'ProfileController@index');
    Route::get('profile/block', 'ProfileController@block');
    Route::get('messages/inbox', 'ProfileController@inbox');
    Route::post('profile/message', 'ProfileController@postMessage');
    Route::patch('profile/settings/{id}', 'ProfileController@update');
    Route::patch('profile/change/password/{id}', 'ProfileController@updatePassword');

    /** Login User Resource Routes **/
	Route::resource('/users', 'Admin\UserController');

	/** Business Settings Routes **/
	Route::resource('/business', 'Admin\BusinessController');

    Route::get('area/{id}/customers', 'Admin\AreaController@listCustomers');
	Route::resource('/area', 'Admin\AreaController');

	Route::resource('/season', 'Admin\SeasonController');

    /** Customer Resource Routes **/
    Route::resource('/customer', 'Admin\CustomerController');
    Route::get('customers/{id}/reports/{season}/print', 'Admin\CustomerController@printReport');
    Route::get('/customer/{id}/report/{season?}', 'Admin\CustomerController@previousReports');

    /** Expense Bills */
    Route::resource('expense', 'ExpenseController', ['except' => ['destroy', 'show']]);

	/** Schedules **/
	Route::resource('schedule', 'ScheduleController', ['except' => ['index', 'destroy']]);
    Route::get('schedule/search/{business}/{start?}/{end?}', 'ScheduleController@show');
    Route::post('api/schedules/completed', 'ApiController@completeSchedule');
    Route::get('schedules/incomplete/{id}', 'ApiController@IncompleteSchedule');
    Route::get('schedules/delete/{id}', 'ScheduleController@destroy');

    /** Payments **/
    Route::get('payment/lists', 'PaymentController@listPayments');
	Route::get('payment/{id?}', 'PaymentController@index');
	Route::post('payment', 'PaymentController@store');
    Route::patch('payment/edit/{id}', 'PaymentController@update');
    Route::delete('payment/delete/{id}', 'PaymentController@destroy');

    /** APIs **/
    Route::get('api/areas/business/{id}', 'ApiController@areasByBusiness');

    /** Main Reports **/
    Route::get('report/income/{id?}', 'Report\MainReportController@income');
    Route::get('report/balance/{id?}', 'Report\MainReportController@balanceSheet');
    Route::get('report/due/{id?}', 'Report\MainReportController@due');
    Route::get('report/{id?}', 'Report\MainReportController@index');

    /** Sub Reports **/
    Route::get('sub', 'Report\SubReportController@listSubgroups');
    Route::get('sub/{group}/income/{id?}', 'Report\SubReportController@income');
    Route::get('sub/{group}/balance/{id?}', 'Report\SubReportController@balanceSheet');
    Route::get('sub/{group}/due/{id?}', 'Report\SubReportController@due');
    Route::get('sub/{group}/{id?}', 'Report\SubReportController@expense');


    /** Logout Routes **/
	Route::get('/logout', 'Auth\AuthController@logout');
});

Route::group(['middleware' => 'guest'], function(){
	Route::get('/', 'Auth\AuthController@getLogin');
	Route::post('/', 'Auth\AuthController@postLogin');
});


Route::get('api/v1', 'Api\ApiController@index');
