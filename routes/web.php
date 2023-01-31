<?php

use App\Http\Controllers\ProductController;
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

//Route for list, add and edit product
Route::controller(ProductController::class)->group(function () {
    Route::get('products-list', 'productList')->name('list.product');
    Route::match(['GET,', 'POST'], 'new-product', 'newProduct')->name('new.product');
    Route::match(['GET,', 'POST'], 'edit-product/{product}', 'editProduct')->name('edit.product');
});
