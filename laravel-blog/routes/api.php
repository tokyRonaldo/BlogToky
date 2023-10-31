<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

Route::middleware('auth:sanctum')->group(function () {
    // Vos routes protégées par Sanctum
    Route::get('/user/connected','App\Http\Controllers\Api\AuthController@user');
});

Route::middleware(['auth:sanctum', 'checkRole:admin'])->group(function () {
    // Routes accessibles uniquement pour les utilisateurs avec le rôle "admin"
    Route::get('/page/create', [App\Http\Controllers\PageController::class, 'create'])->name('page_create'); 
    Route::post('/page/update/{id}', [App\Http\Controllers\PageController::class, 'update'])->name('page_update'); 
    Route::post('/page/store', [App\Http\Controllers\PageController::class, 'store'])->name('page_store'); 
    Route::get('/page/edit/{id}', [App\Http\Controllers\PageController::class, 'edit'])->name('page_edit'); 
    Route::get('/page/show/{id}', [App\Http\Controllers\PageController::class, 'show'])->name('page_show'); 
    Route::get('/page/destroy/{id}', [App\Http\Controllers\PageController::class, 'destroy'])->name('page_destroy');
});

//Page
Route::get('page', 'App\Http\Controllers\PageController@index')->name('page_index');
Route::get('/page/checkPage', [App\Http\Controllers\PageController::class, 'checkPage'])->name('page_check');

//article
Route::get('article', 'App\Http\Controllers\ArticleController@index')->name('article_index');
Route::get('/article/create', [App\Http\Controllers\ArticleController::class, 'create'])->name('article_create'); 
Route::post('/article/update/{id}', [App\Http\Controllers\ArticleController::class, 'update'])->name('article_update'); 
Route::post('/article/store', [App\Http\Controllers\ArticleController::class, 'store'])->name('article_store'); 
Route::get('/article/edit/{id}', [App\Http\Controllers\ArticleController::class, 'edit'])->name('article_edit'); 
Route::get('/article/show/{id}', [App\Http\Controllers\ArticleController::class, 'show'])->name('article_show'); 
Route::get('/article/destroy/{id}', [App\Http\Controllers\ArticleController::class, 'destroy'])->name('article_destroy');
Route::get('/allArticle', [App\Http\Controllers\ArticleController::class, 'allArticle'])->name('article_all');

//user
Route::get('user', 'App\Http\Controllers\UserController@index')->name('user_index');
Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user_create'); 
Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user_update'); 
Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user_store'); 
Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user_edit'); 
Route::get('/user/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user_show'); 
Route::get('/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user_destroy');

//categorie
Route::get('categorie', 'App\Http\Controllers\CategorieController@index')->name('categorie_index');
Route::get('/categorie/create', [App\Http\Controllers\CategorieController::class, 'create'])->name('categorie_create'); 
Route::post('/categorie/update/{id}', [App\Http\Controllers\CategorieController::class, 'update'])->name('categorie_update'); 
Route::post('/categorie/store', [App\Http\Controllers\CategorieController::class, 'store'])->name('categorie_store'); 
Route::get('/categorie/edit/{id}', [App\Http\Controllers\CategorieController::class, 'edit'])->name('categorie_edit'); 
Route::get('/categorie/show/{id}', [App\Http\Controllers\CategorieController::class, 'show'])->name('categorie_show'); 
Route::get('/categorie/destroy/{id}', [App\Http\Controllers\CategorieController::class, 'destroy'])->name('categorie_destroy');
Route::get('/categorie/{id}', [App\Http\Controllers\CategorieController::class, 'articleCategorie'])->name('categorie_article');

//Media
Route::get('media', 'App\Http\Controllers\MediaController@index')->name('media_index');
Route::get('/media/create', [App\Http\Controllers\MediaController::class, 'create'])->name('media_create'); 
Route::post('/media/update/{id}', [App\Http\Controllers\MediaController::class, 'update'])->name('media_update'); 
Route::post('/media/store', [App\Http\Controllers\MediaController::class, 'store'])->name('media_store'); 
Route::get('/media/edit/{id}', [App\Http\Controllers\MediaController::class, 'edit'])->name('media_edit'); 
Route::get('/media/show/{id}', [App\Http\Controllers\MediaController::class, 'show'])->name('media_show'); 
Route::get('/media/destroy/{id}', [App\Http\Controllers\MediaController::class, 'destroy'])->name('media_destroy');


//commentaire
Route::get('commentaire', 'App\Http\Controllers\CommentaireController@index')->name('commentaire_index');
Route::get('/commentaire/create', [App\Http\Controllers\CommentaireController::class, 'create'])->name('commentaire_create'); 
Route::post('/commentaire/update/{id}', [App\Http\Controllers\CommentaireController::class, 'update'])->name('commentaire_update'); 
Route::post('/commentaire/store', [App\Http\Controllers\CommentaireController::class, 'store'])->name('commentaire_store'); 
Route::get('/commentaire/edit/{id}', [App\Http\Controllers\CommentaireController::class, 'edit'])->name('commentaire_edit'); 
Route::get('/commentaire/show/{id}', [App\Http\Controllers\CommentaireController::class, 'show'])->name('commentaire_show'); 
Route::get('/commentaire/destroy/{id}', [App\Http\Controllers\CommentaireController::class, 'destroy'])->name('commentaire_destroy');

//accueil
Route::get('/accueil/article', [App\Http\Controllers\ArticleController::class, 'accueilArticle'])->name('article_accueil');
Route::get('/accueil/apropos', [App\Http\Controllers\PageController::class, 'accueilApropos'])->name('apropos_accueil');
Route::get('/accueil/categorie', [App\Http\Controllers\CategorieController::class, 'accueilCategorie'])->name('categorie_accueil');
