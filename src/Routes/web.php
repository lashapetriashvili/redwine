<?php

use Redwine\Facades\Redwine;

Route::group(['middleware' => ['web', 'redwine']], function () {

    $controllerNamespace = Redwine::controllerNamespace();

    // Redwine login
    Route::get('redwine/login', $controllerNamespace . '\Auth\LoginController@showLoginForm')->name('redwine.login');
    Route::post('redwine/login', $controllerNamespace . '\Auth\LoginController@login')->name('redwine.login.submit');
    Route::get('redwine/logout', $controllerNamespace . '\Auth\LoginController@logout')->name('redwine.logout');

    // Redwine
    Route::get('redwine/', $controllerNamespace . '\DashboardController@index')->name('redwine.dashboard');

    // Redwine Database
    Route::get('redwine/database/table', $controllerNamespace . '\DatabaseController@index')->name('redwine.database.browse');
    Route::get('redwine/database/read', $controllerNamespace . '\DatabaseController@read')->name('redwine.database.read');
    Route::get('redwine/database/add', $controllerNamespace . '\DatabaseController@add')->name('redwine.database.add');
    Route::post('redwine/database/add', $controllerNamespace . '\DatabaseController@storeDatabase')->name('redwine.database.store.database');
    Route::post('redwine/database/delete/{table}', $controllerNamespace . '\DatabaseController@delete')->name('redwine.database.delete');

    // Redwine Custom Page
    Route::get('redwine/custompage/{table}', $controllerNamespace . '\CustomPageController@index')->name('redwine.custom.page.browse');
    Route::post('redwine/custompage/add', $controllerNamespace . '\CustomPageController@add')->name('redwine.custom.page.add');
    Route::get('redwine/custompage/edit/{table}', $controllerNamespace . '\CustomPageController@viewEdit')->name('redwine.custom.page.view.edit');
    Route::post('redwine/custompage/edit', $controllerNamespace . '\CustomPageController@edit')->name('redwine.custom.page.edit');

    // Redwine Page
    Route::get('redwine/page/{slug}', $controllerNamespace . '\PageController@index')->name('redwine.page.browse');
    Route::get('redwine/page/{slug}/{id}/read', $controllerNamespace . '\PageController@read')->name('redwine.page.read');
     Route::get('redwine/page/{slug}/view', $controllerNamespace . '\PageController@viewJson')->name('redwine.page.viewJson');
    Route::get('redwine/page/{slug}/add', $controllerNamespace . '\PageController@viewAdd')->name('redwine.page.view.add');
    Route::post('redwine/page/{slug}/check/slug', $controllerNamespace . '\PageController@slug')->name('redwine.page.check.slug');
    Route::post('redwine/page/{slug}/check/unique', $controllerNamespace . '\PageController@unique')->name('redwine.page.check.unique');
    Route::post('redwine/page/{slug}/add', $controllerNamespace . '\PageController@add')->name('redwine.page.add');
    Route::get('redwine/page/{slug}/{id}/edit', $controllerNamespace . '\PageController@viewEdit')->name('redwine.page.view.edit');
    Route::post('redwine/page/{slug}/{id}/edit', $controllerNamespace . '\PageController@edit')->name('redwine.page.edit');
    Route::post('redwine/page/{slug}/{id}/delete', $controllerNamespace . '\PageController@delete')->name('redwine.page.delete');

    // Redwine Permission
    Route::get('redwine/permission/table', $controllerNamespace . '\PermissionController@index')->name('redwine.permission.browse');
    Route::get('redwine/permission/add', $controllerNamespace . '\PermissionController@viewAdd')->name('redwine.permission.view.add');
    Route::post('redwine/permission/add', $controllerNamespace . '\PermissionController@add')->name('redwine.permission.add');
    Route::get('redwine/permission/edit/{id}', $controllerNamespace . '\PermissionController@viewEdit')->name('redwine.permission.view.edit');
    Route::post('redwine/permission/edit/{id}', $controllerNamespace . '\PermissionController@edit')->name('redwine.permission.edit');
    Route::post('redwine/permission/delete/{id}', $controllerNamespace . '\PermissionController@delete')->name('redwine.permission.delte');

    // Redwine Menu
    Route::get('redwine/menu/table', $controllerNamespace . '\MenuController@index')->name('redwine.menu.browse');
    Route::get('redwine/menu/add', $controllerNamespace . '\MenuController@add')->name('redwine.menu.add');
    Route::post('redwine/menu/check/{name}', $controllerNamespace . '\MenuController@check')->name('redwine.page.check');
    Route::get('redwine/menu/edit/{name}', $controllerNamespace . '\MenuController@edit')->name('redwine.menu.edit');
    Route::post('redwine/menu/save', $controllerNamespace . '\MenuController@save')->name('redwine.menu.add');
    Route::post('redwine/menu/save/change', $controllerNamespace . '\MenuController@saveChange')->name('redwine.menu.edit');
    Route::post('redwine/menu/delete', $controllerNamespace . '\MenuController@delete')->name('redwine.menu.delete');
    Route::post('redwine/menu/menus/delete/{name}', $controllerNamespace . '\MenuController@menuDelete')->name('redwine.menu.delete');
});
