<?php

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


$this->group(['namespace' => 'Front', 'middleware' => [/*'web', 'auth'*/]], function () {

    $this->get('/', 'PaymentController@index');

    //payment
    $this->post('payment', 'PaymentController@payment')->name('front.payment');
    $this->get('order', 'PaymentController@order')->name('front.order');
    $this->get('success/{id}', 'PaymentController@successPayment')->name('front.success.payment');
    $this->get('failure/{id}', 'PaymentController@failurePayment')->name('front.failure.payment');

});

//Auth::routes();

$middleware = ['web', 'auth'];
$this->group(['prefix' => 'Admin', 'namespace' => 'Admin', 'middleware' => $middleware], function () {

    $this->get('User/auto-complete', 'UserController@autoComplete')->name("user.autoComplete");

    $this->adminGenerator('User', 'UserController');
    $this->adminGenerator('UserAccountSetting', 'UserAccountSettingController');
    $this->adminGenerator('UserGatewayLog', 'UserGatewayLogController');
    $this->adminGenerator('UserBalanceLog', 'UserBalanceLogController');
    $this->adminGenerator('Country', 'CountryController');
    $this->adminGenerator('Currency', 'CurrencyController');

});