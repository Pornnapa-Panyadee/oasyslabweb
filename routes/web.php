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

Route::get('/', function () {
    return view('frontend.home');
});

Route::group([], function() {
    Route::get('/', 'HomeController@indexFrontend');
    Route::get('/publications', 'HomeController@indexPublications');
    Route::get('/members', 'HomeController@indexMembers');
    Route::get('/member/{slug}','HomeController@indexMember');
    Route::get('/field/{slug}', 'HomeController@indexField');
    Route::get('/article/{slug}', 'HomeController@indexArticle');
});

Route::group(['prefix' => 'api'], function() {
    Route::get('/banners', 'HomeController@getBanners');
    Route::get('/aboutus', 'HomeController@getAboutUs');
    Route::get('/contact', 'HomeController@getContact');
    Route::get('/projects', 'HomeController@getProjects');
    Route::get('/members', 'HomeController@getMembers');
    Route::get('/member/{slug}', 'HomeController@getMember');
    Route::get('/publications', 'HomeController@getPublications');
    Route::get('/tags', 'HomeController@getTags');
    Route::get('/tag/{slug}', 'HomeController@getTag');
    Route::get('/colors', 'HomeController@getColors');
    Route::get('/article/{slug}', 'HomeController@getArticle');
    Route::get('/articles', 'HomeController@getArticles');
    Route::get('/sections', 'HomeController@getSections');
});

Route::group(['prefix' => 'backend'], function() {
    Auth::routes();
    Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index')->name('users');
        Route::get('/deleted', 'UsersController@showDeletedUsers')->name('users.deletedUser');
        Route::get('/create', 'Auth\RegisterController@showRegistrationForm')->name('users.createUser');
        Route::get('/edit/{id}', 'Auth\ResetPasswordController@showResetForm')->name('users.edit');
        Route::delete('/delete/{id}', 'UsersController@deleteUser')->name('users.delete');
        Route::get('/restore/{id}','UsersController@RestoreUser')->name('users.restore');
    });
    Route::group(['prefix' => 'settings'], function() {
        Route::get('/banner', 'SettingsController@bannerIndex')->name('settings.banner');
        Route::get('/detail', 'SettingsController@detailIndex')->name('settings.detail');
        Route::get('/color', 'SettingsController@colorIndex')->name('settings.color');
        Route::get('/section', 'SettingsController@sectionIndex')->name('settings.section');
        Route::post('/detail/{id}', 'SettingsController@detailEdit')->name('settings.detail.edit');
        Route::post('/banner/{id}', 'SettingsController@bannerEdit')->name('settings.banner.edit');
        Route::post('/colors', 'SettingsController@colorsEdit')->name('settings.colors.edit');
        Route::post('/sections', 'SettingsController@sectionsEdit')->name('settings.section.edit');
    });
    Route::group(['prefix' => 'images'], function() {
        Route::get('/', 'ImagesController@index')->name('images');
        Route::get('/ajax', 'ImagesController@ajax');
        Route::post('/upload', 'ImagesController@upload')->name('images.upload');
        Route::delete('/delete/{id}', 'ImagesController@deleteImage')->name('images.delete');
    });
    Route::group(['prefix' => 'members'], function() {
        Route::get('/', 'MembersController@index')->name('members');
        Route::get('/create', 'MembersController@create')->name('members.create');
        Route::post('/create', 'MembersController@createMember')->name('members.createMember');
        Route::get('/edit/{id}', 'MembersController@edit')->name('members.edit');
        Route::post('/edit/{id}', 'MembersController@editMember')->name('members.editMembers');
        Route::delete('/delete/{id}', 'MembersController@deleteMember')->name('members.delete');
        Route::post('/add-position', 'MembersController@createPosition')->name('members.position.add');
        Route::delete('/delete-position/{id}', 'MembersController@deletePosition')->name('members.position.delete');
        Route::post('/add-field', 'MembersController@createField')->name('members.field.add');
        Route::put('/edit-field/{id}', 'MembersController@editField')->name('members.field.edit');
        Route::delete('/delete-field/{id}', 'MembersController@deleteField')->name('members.field.delete');
    });
    Route::group(['prefix' => 'projects'], function() {
        Route::get('/', 'ProjectsController@index')->name('projects');
        Route::get('/create', 'ProjectsController@create')->name('projects.create');
        Route::post('/create', 'ProjectsController@createProject')->name('projects.createProject');
        Route::get('/edit/{id}', 'ProjectsController@edit')->name('projects.edit');
        Route::post('/edit/{id}', 'ProjectsController@editProject')->name('projects.editProject');
        Route::get('/sub-project/{id}', 'ProjectsController@getSubProject')->name('projects.subproject');
        Route::get('/create-sub-project/{id}', 'ProjectsController@createSub')->name('projects.createSub');
        Route::post('/create-sub-project', 'ProjectsController@createSubProject')->name('projects.createSubProject');
        Route::get('/edit-sub-project/{id}', 'ProjectsController@editSub')->name('projects.editSub');
        Route::post('/edit-sub-project/{id}', 'ProjectsController@editSubProject')->name('projects.editSubProject');
        Route::delete('/delete-sub/{id}', 'ProjectsController@deleteSubProject')->name('projects.sub.delete');
        Route::delete('/delete/{id}', 'ProjectsController@deleteMainProject')->name('projects.delete');
    });
    Route::group(['prefix' => 'publications'], function() {
        Route::get('/', 'PublicationsController@index')->name('publications');
        Route::get('/create', 'PublicationsController@create')->name('publications.create');
        Route::post('/create', 'PublicationsController@createPublication')->name('publications.createPublication');
        Route::get('/edit/{id}', 'PublicationsController@edit')->name('publications.edit');
        Route::post('/edit/{id}', 'PublicationsController@editPublication')->name('publications.editPublication');
        Route::delete('/delete/{id}', 'PublicationsController@deletePublication')->name('users.delete');
    });
    Route::group(['prefix' => 'article'], function () {
        Route::get('/','ArticleController@index')->name('article');
        Route::get('/create', 'ArticleController@showCreateArticleForm')->name('article.createArticle');
        Route::post('/createArticle', 'ArticleController@create')->name('article.create');
        Route::get('/edit/{id}', 'ArticleController@showEditArticleForm')->name('article.edit');
        Route::post('/editArticle/{id}', 'ArticleController@edit')->name('article.editArticle');
        Route::delete('/delete/{id}', 'ArticleController@delete')->name('article.delete');
        Route::get('/publish/{id}', 'ArticleController@changeToPublish')->name('article.publish');
        Route::get('/draft/{id}', 'ArticleController@changeToDraft')->name('article.draft');
    });
});
