<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Classes\ClassController;
use App\Http\Controllers\PageRouteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Test\TestController;
use App\Models\Test;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageRouteController::class, 'IndexPage'])->name('index');

Route::get('/login/{type}', [PageRouteController::class, 'loginPage'])->where('type', 'student|guardian')->name('login');
Route::post('/login/{type}', [AuthController::class, 'LoginStore'])->name('login-post');

Route::get('/register/{type}', [PageRouteController::class, 'registerPage'])->where('type', 'student|guardian')->name('register');
Route::post('/register/{type}', [AuthController::class, 'RegisterStore'])->name('register-post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [PageRouteController::class, 'DashboardPage'])->name('dashboard');
Route::get('/classes', [PageRouteController::class, 'ClassesPage'])->name('classes');
Route::get('/classes/profile/{id}', [PageRouteController::class, 'ClassesProfilePage'])->name('classes.profile');
Route::get('/classes/profile/test/{id}/{class}', [PageRouteController::class, 'TesdtPage'])->name('classes.test');
Route::post('/classes/profile/test/{id}', [TestController::class, 'TestSubmit'])->name('classes.test.submit');
Route::get('/classes/profile/test-result/{test_id}', [PageRouteController::class, 'TestResult'])->name('classes.test.result');
Route::get('/payment/{class_id?}/{month_id?}',[PageRouteController::class, 'PaymentPage'])->name('payment');
Route::post('/payment',[PageRouteController::class, 'PaymentSubmit'])->name('payment-submit');
Route::get('/send-request/{class_id?}/{month_id?}',[PageRouteController::class, 'SendRequest'])->name('SendRequest');

Route::get('/student/form', [StudentController::class, 'index'])->name('add-student-form');
Route::post('/student/form', [StudentController::class, 'store'])->name('add-student-store');
Route::get('/student/login/{id}', [StudentController::class, 'Login'])->name('student-login');
Route::get('/student/forget-1', [StudentController::class, 'forget01'])->name('student-forget');
Route::get('/student/forget-2', [StudentController::class, 'forget02'])->name('student-comfirmOtpView');
Route::Post('/student/forget-1', [StudentController::class, 'PostForget01'])->name('student-forget-post');
Route::Post('/student/forget-2', [StudentController::class, 'PostForget02'])->name('student-forget2-post');





