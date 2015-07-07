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

namespace base_tag\config;

use lithium\g11n\Message;
use base_core\extensions\cms\Panes;

extract(Message::aliases());

Panes::register('authoring.tags', [
	'title' => $t('Tags', ['scope' => 'base_tag']),
	'url' => ['controller' => 'tags', 'action' => 'index', 'library' => 'base_tag', 'admin' => true],
	'weight' => 70
]);

?>