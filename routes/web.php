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
    return view('welcome');
});

Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::get('register', 'Auth\RegisterController@showRegisterForm');
Route::post('register', 'Auth\RegisterController@createUser')->name('register');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['middleware' => 'auth'], function (){
    Route::get('/dashboard','DashboardController@index');
    Route::get('/ships','DashboardController@Ships')->name('ships');
    Route::get('/form/ship/{ship_id}','DashboardController@FormShip')->name('formShip');
    Route::post('/form/ship/','DashboardController@StoreShip')->name('storeShip');
    Route::delete('/delete/ship/{ship_id}','DashboardController@deleteShip')->name('deleteShip');
    Route::post('/dashboard/updateprofile/{id}','ProfileController@update')->name('dashboard.updateprofile');
	
	//# Ship Schedule page route
	
	Route::get('/ship/schedules/{id}','DashboardController@schedules');
	Route::post('/ship/processSchedule','DashboardController@FormSchedule');
	Route::post('/ship/updateSchedule','DashboardController@updateSchedule');
	Route::get('/ship/rows/{id}','DashboardController@fetchScheduleTableRows');
	Route::get('/ship/deleteSchedule/{id}','DashboardController@deleteSchedule');
	Route::get('/ship/getSchedule/{id}','DashboardController@getSchedule');
	Route::get('/dashboard','DashboardController@index')->name('dashboard');
	Route::post('/dashboard/updateprofile/{id}','ProfileController@update')->name('dashboard.updateprofile');
	Route::get('/form/ship/{ship_id}','ShipController@FormShip')->name('formShip');
	Route::get('/ships','ShipController@Ships')->name('ships');
	Route::get('/ship/{ship_id}','ShipController@ViewShip')->name('view_ship');
    Route::post('/form/ship/','ShipController@StoreShip')->name('storeShip');
    Route::delete('/delete/ship/{ship_id}','ShipController@deleteShip')->name('deleteShip');
    Route::post('/upload/image/ship/','ShipController@StoreImageShip')->name('storeImageShip');
    Route::post('/form/ship/{ship_id}/feed','ShipController@StoreFeedShip')->name('storeFeedShip');
    Route::get('/ship/user/feeds','ShipController@GetShipFeedByUser')->name('getShipUserFeed');
    Route::get('/ship/{ship_id}/feeds','ShipController@getShipFeed')->name('getShipFeed');
    Route::post('/form/comment/ship','ShipController@ShipCommentFeed')->name('formShipCommentFeed');
    Route::get('/count/news/feed/','ShipController@countNewsFeeds')->name('countNewsFeeds');

    Route::resource('/form/contacts','ContactsController');
    Route::get('/form/contact-list','ContactsController@showContactDetail')->name('form.contacts.contactList');

    Route::resource('/form/organisation','OrganisationController');
    Route::get('/form/add-organisation','OrganisationController@addOrganisationForm')->name('form.organisation.addForm');

	Route::get('/invitation/action/{user}/{ship}/{notification}', 'InvitationController@action')->name('invitation.action');
	Route::post('/invitation/decision/{status}/{user}/{ship}/{notification}', 'InvitationController@decision')->name('invitation.decision');
	Route::get('/invitation/{id}/edit', 'InvitationController@edit')->name('invitation.edit');
    Route::delete('/invitation/{id}/{ship_id}', 'InvitationController@destroy')->name('invitation.destroy');

    Route::resource('/form/share_ship','ShareShipsController');
    Route::post('/form/ship_request_accept/{ship_id}','ShareShipsController@shipRequestAccept')->name('ship.request.accept');
    Route::post('/form/ship_request_reject/{ship_id}','ShareShipsController@shipRequestReject')->name('ship.request.reject');

    //projects
    Route::get('projects','ProjectController@Projects')->name('projects');
    Route::get('/project/form/{project_id}','ProjectController@FormProject')->name('form.project');
    Route::post('/project/form','ProjectController@storeProject')->name('form.store.project');
    Route::post('/project/{project_id}/close','ProjectController@closeProject')->name('project.form.close');
    Route::delete('/project/form/{project_id}','ProjectController@deleteProject')->name('project.form.delete');
    Route::get('/project/view/{project_id}','ProjectController@viewProject')->name('project.view');
    Route::post('/project/feed/reply','ProjectController@StoreFeedReply')->name('project.feed.reply.store');
    Route::get('/project/count/news/feed/','ProjectController@countNewsFeeds')->name('project.count.new.feed');

    Route::get('/project/invitation/action/{user}/{project}/{notification}', 'ProjectInvitationController@action')->name('project.invitation.action');
    Route::post('/project/invitation/decision/{status}/{user}/{project}/{notification}', 'ProjectInvitationController@decision')->name('project.invitation.decision');
    Route::get('/project/invitation/{id}/edit', 'ProjectInvitationController@edit')->name('project.invitation.edit');
    Route::post('/project/invitation/{project_id}/{invited_user_id}/perimssions', 'ProjectInvitationController@editPermissions')->name('project.invitation.permissions');
    Route::delete('/project/invitation/{id}/{ship_id}', 'ProjectInvitationController@destroy')->name('project.invitation.destroy');
    Route::resource('/project/share','ProjectShareController');
    Route::post('/project/invitation/request-accept/{project_id}','ProjectShareController@shipRequestAccept')->name('project.request.accept');
    Route::post('/project/invitation/request-reject/{project_id}','ProjectShareController@shipRequestReject')->name('project.request.reject');

    //costs
    Route::post('/project/form/cost','ProjectController@formCosts')->name('project.form.cost');
    Route::post('/project/cost/action','ProjectController@actionCost')->name('project.cost.action');
    Route::delete('/project/cost/remove','ProjectController@removeCost')->name('project.cost.remove');


    Route::get('/project/{project_id}/costs','ProjectController@getCosts')->name('project.get.cost');
    Route::get('/project/{project_id}/feeds','ProjectController@feedsProject')->name('project.feeds');
    Route::post('/project/{project_id}/feed','ProjectController@StoreFeed')->name('project.feed.store');
    // -- projects
});