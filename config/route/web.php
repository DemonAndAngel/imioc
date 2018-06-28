<?php
use imden\base\Route;
Route::get('test',['as'=>'test','uses'=>'TestController@test']);
Route::post('test',['as'=>'test','uses'=>'TestController@post']);