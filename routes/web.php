<?php

use App\Http\Controllers\admin\DashboardAdminController;
use App\Http\Controllers\admin\FormsAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Models\Category;
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



//Language rout
Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');
//Language CKEditor
Route::post('ckeditor/upload', [CKEditorController::class, "upload"])->name('ckeditor.image-upload');

Route::get('/',[DashboardAdminController::class,'index']);
Route::get('form_one',[FormsAdminController::class,'form_one'])->name('form_one');
