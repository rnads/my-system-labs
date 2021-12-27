<?php

use App\Http\Controllers\{HomeController, StudentController, TeacherController};
use Illuminate\Support\Facades\{Auth, Route};
use TJGazel\LaravelDocBlockAcl\Facades\Acl;

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

Acl::routes([
    'middleware' => ['auth', 'acl'],
    'prefix' => 'acl',
    'name' => 'acl.'
]);

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher');
});
