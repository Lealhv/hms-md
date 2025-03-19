<?php
// Here you can configure the routes
$router->post('/verify', 'AuthController@verifyCode');
$router->post('/records', 'RecordController@createRecord');
$router->get('/records', 'RecordController@getRecords');
