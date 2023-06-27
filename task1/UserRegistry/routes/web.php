<?php

use App\Http\Controllers\UserListing;
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
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/users', 'UserListing@index')->name('users.index');
    Route::get('/users/create', 'UserListing@create')->name('users.create');
    Route::post('/users', 'UserListing@store')->name('users.store');
    Route::get('/users/{user}', 'UserListing@show')->name('users.show');
    Route::get('/users/{user}/edit', 'UserListing@edit')->name('users.edit');
    Route::put('/users/{user}', 'UserListing@update')->name('users.update');
    Route::delete('/users/{user}', 'UserListing@destroy')->name('users.destroy');
});

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/users', [UserListing::class, 'index'])->name('users.index');
//     Route::get('/users/create', [UserListing::class, 'create'])->name('users.create');
//     Route::post('/users', [UserListing::class, 'store'])->name('users.store');
//     Route::get('/users/{user}', [UserListing::class, 'show'])->name('users.show');
//     Route::get('/users/{user}/edit', [UserListing::class, 'edit'])->name('users.edit');
//     Route::put('/users/{user}', [UserListing::class, 'update'])->name('users.update');
//     Route::delete('/users/{user}', [UserListing::class, 'destroy'])->name('users.destroy');
// });



// Route::get('/users', function () {
//     $dummyUsers = [
//         [
//             'id' => 1,
//             'name' => 'Johnny',
//             'surname' => 'Doe',
//             'email' => 'john@example.com',
//         ],
//         [
//             'id' => 2,
//             'name' => 'Jane',
//             'surname' => 'Smith',
//             'email' => 'jane@example.com',
//         ],
//         [
//             'id' => 3,
//             'name' => 'Amanda',
//             'surname' => 'Becky',
//             'email' => 'amanda@becky.com',
//         ],
//         [
//             'id' => 4,
//             'name' => 'Paul',
//             'surname' => 'Smith',
//             'email' => 'paulloe@example.com',
//         ],
//         // Adding dummy data to test the table functionalities, not for production
//     ];

//     return view('users', compact('dummyUsers'));
// })->name('users.index');

// Route::get('/users', 'UserListing@index');
// Route::get('/users/create', 'UserListing@create');
// Route::post('/users', 'UserListing@store');
// Route::get('/users/{user}', 'UserListing@show');
// Route::get('/users/{user}/edit', 'UserListing@edit');
// Route::put('/users/{user}', 'UserListing@update');
// Route::delete('/users/{user}', 'UserListing@destroy');




