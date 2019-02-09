<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\RestTagApi\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
	   ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
	   ['name' => 'page#do_echo', 'url' => '/echo', 'verb' => 'POST'],
	   ['name' => 'RestTagApi#setFileTags', 'url' => '/api/v1/restapi/{path}', 'verb' => 'POST', 'requirements' => ['path' => '.+']],
	   ['name' => 'RestTagApi#updateFileTags', 'url' => '/api/v1/restapi/{path}', 'verb' => 'PUT', 'requirements' => ['path' => '.+']],
	   ['name' => 'RestTagApi#getFileTags', 'url' => '/api/v1/restapi/{path}', 'verb' => 'GET', 'requirements' => ['path' => '.+']],
	   ['name' => 'RestTagApi#removeTag', 'url' => '/api/v1/restapi/tags/{id}', 'verb' => 'DELETE', 'requirements' => ['id' => '\d+']],
	   ['name' => 'RestOldTagApi#updateFileTags', 'url' => '/api/v0/restapi/{path}', 'verb' => 'POST', 'requirements' => ['path' => '.+']],
	   ['name' => 'RestOldTagApi#getFileTags', 'url' => '/api/v0/restapi/{path}', 'verb' => 'GET', 'requirements' => ['path' => '.+']],
    ]
];
