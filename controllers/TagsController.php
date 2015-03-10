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

namespace base_tag\controllers;

use base_tag\models\Tags;
use jsend\Response as JSendResponse;
use lithium\g11n\Message;
use li3_flash_message\extensions\storage\FlashMessage;

class TagsController extends \base_core\controllers\BaseController {

	use \base_core\controllers\AdminAddTrait;
	use \base_core\controllers\AdminEditTrait;
	use \base_core\controllers\AdminDeleteTrait;

	use \base_core\controllers\AdminPublishTrait;

	public function admin_index() {
		$data = Tags::find('all', [
			'order' => ['name' => 'ASC']
		]);
		return compact('data');
	}

	public function admin_api_index() {
		$response = new JSendResponse();

		$data = Tags::find('all', [
			'order' => ['name' => 'ASC']
		]);
		$response->success($data);

		$this->render([
			'type' => $this->request->accepts(),
			'data' => $response->to('array')
		]);
	}

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

		if ($result = Tags::clean()) {
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