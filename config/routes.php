<?php
/**
 * Base Tag
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

use lithium\net\http\Router;

$persist = ['persist' => ['admin', 'controller']];

Router::connect('/admin/tags/{:id:[0-9]+}', [
	'controller' => 'tags', 'library' => 'base_tag', 'action' => 'view', 'admin' => true
], $persist);
Router::connect('/admin/tags/{:action}', [
	'controller' => 'tags', 'library' => 'base_tag', 'admin' => true
], $persist);
Router::connect('/admin/tags/{:action}/{:id:[0-9]+}', [
	'controller' => 'tags', 'library' => 'base_tag', 'admin' => true
], $persist);
Router::connect(
	'/admin/api/tags',
	['controller' => 'tags', 'action' => 'api_index', 'library' => 'base_tag', 'admin' => true]
);

?>