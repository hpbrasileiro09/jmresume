<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['auth','admin']], function() {
	/*
	Route::get('/', function () {
	    return view('welcome')->with(\Helpers::getDataAdminLTE());
	})->name('dashboard');
	*/
	Route::get('/', 'AdminController@index')->name('dashboard');
	Route::get('/admin', 'AdminController@index');
	Route::resource('/users', 'UsersController');
	Route::get('/entry/support', ['as' => 'entry.support', 'uses' => 'EntryController@support']);
	Route::post('/entry/supportsave', ['as' => 'entry.supportsave', 'uses' => 'EntryController@supportsave']);
	Route::resource('/entry', 'EntryController');
	Route::resource('/category', 'CategoryController');
	Route::resource('/param', 'ParamController');
	Route::resource('/time', 'TimeController',['except' => ['create','destroy']]);
	Route::get('/dump/backup', ['as' => 'dump.backup', 'uses' => 'DumpController@backup']);
	Route::resource('/dump', 'DumpController',['except' => ['create','destroy']]);
	Route::resource('/person', 'PersonController',['except' => ['index','create','store','destroy']]);
	Route::get('/reports/detalhe', ['as' => 'reports.detalhe', 'uses' => 'ReportController@detalhe']);
	Route::get('/entry/json/{id}', 'EntryController@entryjson');
	Route::post('/entry/save', 'EntryController@entrysave');
});

Route::group(['middleware' => 'cors'], function() {

	Route::post('oauth/access_token', function () {
		try {
			$acessToken = Response::json(Authorizer::issueAccessToken());
			return $acessToken;
		} catch (Exception $exc) {
			return Array('error' => $exc->getMessage());
		}
	});

	Route::group(['prefix' => 'api', 'middleware' => 'oauth', 'as' => 'api.'], function() {
		
	    //Dados do usuário autenticado
		Route::get('/authenticated', ['as' => 'authenticated', 'uses' => 'PersonController@person']);

		//Finalizar o procedimento de renovação de senha
		Route::post('/passwordreset', 'PersonController@passwordreset');

	});

});

//Email, verificar a existência do mesmo e encaminhar link para procedimento de renovação de senha
Route::post('/passwordrenew', 'PersonController@passwordrenew');

Route::get('stimages/{filename}', function ($filename) {
	$path = storage_path() . '/app/' . $filename;

	$file = File::get($path);
	$type = File::mimeType($path);

	$response = Response::make($file, 200);
	$response->header("Content-Type", $type);

	return $response;
});

Route::get('stimages/{diretorio}/{filename}', function ($diretorio, $filename) {
	$path = storage_path() . '/app/' . $diretorio . '/' . $filename;

	$file = File::get($path);
	$type = File::mimeType($path);

	$response = Response::make($file, 200);
	$response->header("Content-Type", $type);

	return $response;
});

Route::get('/teste', 'AdminController@teste');
