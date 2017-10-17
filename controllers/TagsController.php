<?php
/**
 * Copyright 2014 David Persson. All rights reserved.
 * Copyright 2016 Atelier Disko. All rights reserved.
 *
 * Use of this source code is governed by a BSD-style
 * license that can be found in the LICENSE file.
 */

namespace base_tag\controllers;

use base_tag\models\Tags;
use lithium\g11n\Message;
use li3_flash_message\extensions\storage\FlashMessage;

class TagsController extends \base_core\controllers\BaseController {

	use \base_core\controllers\AdminIndexTrait;
	use \base_core\controllers\AdminAddTrait;
	use \base_core\controllers\AdminEditTrait;
	use \base_core\controllers\AdminDeleteTrait;
	use \base_core\controllers\AdminPublishTrait;

	public function admin_collect() {
		extract(Message::aliases());

		Tags::pdo()->beginTransaction();

		if ($result = Tags::collect()) {
			Tags::pdo()->commit();
			FlashMessage::write($t('Successfully collected tags.', ['scope' => 'base_tag']), [
				'level' => 'success'
			]);
		} else {
			Tags::pdo()->rollback();
			FlashMessage::write($t('Failed to collect tags.', ['scope' => 'base_tag']), [
				'level' => 'error'
			]);
		}
		return $this->redirect($this->request->referer());
	}

	public function admin_clean() {
		extract(Message::aliases());

		Tags::pdo()->beginTransaction();

		if (Tags::clean()) {
			Tags::pdo()->commit();
			FlashMessage::write($t('Successfully cleaned tags.', ['scope' => 'base_tag']), [
				'level' => 'success'
			]);
		} else {
			Tags::pdo()->rollback();
			FlashMessage::write($t('Failed to clean tags.', ['scope' => 'base_tag']), [
				'level' => 'error'
			]);
		}
		return $this->redirect($this->request->referer());
	}
}

?>