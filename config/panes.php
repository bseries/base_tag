<?php
/**
 * Copyright 2014 David Persson. All rights reserved.
 * Copyright 2016 Atelier Disko. All rights reserved.
 *
 * Use of this source code is governed by a BSD-style
 * license that can be found in the LICENSE file.
 */

namespace base_tag\config;

use lithium\g11n\Message;
use base_core\extensions\cms\Panes;

extract(Message::aliases());

Panes::register('base.tags', [
	'title' => $t('Tags', ['scope' => 'base_tag']),
	'url' => ['controller' => 'tags', 'action' => 'index', 'library' => 'base_tag', 'admin' => true],
	'weight' => 70
]);

?>