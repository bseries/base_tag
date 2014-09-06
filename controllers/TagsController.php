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

class TagsController extends \base_core\controllers\BaseController {

	use \base_core\controllers\AdminAddTrait;
	use \base_core\controllers\AdminEditTrait;
	use \base_core\controllers\AdminDeleteTrait;

	use \base_core\controllers\AdminPublishTrait;

	public function admin_index() {
		$data = Tags::find('all', [
			'order' => ['name' => 'DESC']
		]);
		return compact('data');
	}

	public function admin_api_index() {
		$response = new JSendResponse();

		$data = Tags::find('all', [
			'order' => ['name' => 'DESC']
		]);
		$response->success($data);

		$this->render([
			'type' => $this->request->accepts(),
			'data' => $response->to('array')
		]);
	}
}

?>