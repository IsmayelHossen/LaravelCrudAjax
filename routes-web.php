Route::get('/Ajaxcrud', 'AjaxController@getIndex');
Route::get('/Ajaxcrud/data', 'AjaxController@getData');
Route::post('/Ajaxcrud/store', 'AjaxController@postStore');
Route::post('/Ajaxcrud/update', 'AjaxController@postUpdate');
Route::post('/Ajaxcrud/delete', 'AjaxController@postDelete');