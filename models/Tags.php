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

namespace base_tag\models;

class Tags extends \base_core\models\Base {

	protected static $_actsAs = [
		'base_core\extensions\data\behavior\Timestamp'
	];

	protected static $_dependent = [];

	// Registers a model that uses and depends on tags. Bindings define
	// how exactly the model depends on the tags. It is assumed that
	// each dependent model stores its tags in a _tags_ field and
	// uses the _Taggable_ behavior.
	//
	// ```
	// Tags::registerDependent('cms_post\models\Posts');
	// ```
	public static function registerDependent($model) {
		static::$_dependent[$model] = []; // Value reserved for future use.
	}

	// Finds out which other records depend on a given tag entity.
	// Type can either be count or all.
	public function depend($entity, $type) {
		$depend = $type === 'count' ? 0 : [];

		foreach (static::$_dependent as $model => $unused) {
			$results = $model::find('tag', [ // always use tag finder
				'conditions' => [
					'tags' => $entity->name
				]
			]);
			if ($type === 'count') {
				$depend += $results->count();
			} else {
				foreach ($results as $result) {
					$depend[] = $result;
				}
			}
		}
		return $depend;
	}
}

?>