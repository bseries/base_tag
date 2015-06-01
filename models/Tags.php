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

use lithium\core\Libraries;

class Tags extends \base_core\models\Base {

	protected static $_actsAs = [
		'base_core\extensions\data\behavior\Timestamp',
		'base_core\extensions\data\behavior\Searchable' => [
			'fields' => [
				'name',
				'title'
			]
		]
	];

	public static function collect() {
		$tags = [];

		foreach (static::_dependent() as $model) {
			$results = $model::find('all', [
				'fields' =>  ['tags']
			]);
			if (!$results) {
				continue;
			}
			// Reduced database calls by prefiltering.
			foreach ($results as $result) {
				$tags = array_merge($tags, $result->tags(['serialized' => false]));
			}
		}
		foreach (array_unique($tags) as $tag) {
			if (Tags::find('count', ['conditions' => ['name' => $tag]])) {
				continue; // Do not touch existing.
			}
			if (!Tags::create(['name' => $tag])->save()) {
				return false;
			}
		}
		return true;
	}

	public static function clean() {
		foreach (Tags::find('all') as $tag) {
			if ($tag->depend('count')) {
				continue;
			}
			if (!$tag->delete()) {
				return false;
			}
		}
		return true;
	}

	// Finds out which other records depend on a given tag entity.
	// Type can either be count or all.
	//
	// Do not use in performance criticial parts.
	public function depend($entity, $type) {
		$depend = $type === 'count' ? 0 : [];

		foreach (static::_dependent() as $model) {
			$results = $model::find('tag', [ // always use tag finder
				'conditions' => [
					'tags' => $entity->name
				]
			]);
			if (!$results) {
				continue;
			}
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

	public function title($entity) {
		if ($entity->title) {
			return $entity->title;
		}
		return preg_replace('/^.*:/', '', $entity->name);
	}

	protected static function _dependent() {
		$models = Libraries::locate('models');
		$results = [];

		foreach ($models as $model) {
			// Check if we can call hasBehavior() indirectly.
			if (!is_a($model, '\base_core\models\Base', true)) {
				continue;
			}
			$model::key(); // Hack to activate behaviors.

			if (!$model::hasBehavior('Taggable')) {
				continue;
			}
			$results[] = $model;
		}
		return $results;
	}

	// @deprecated
	public static function registerDependent($model) {
		trigger_error("Tags::registerDependent() is deprecated.", E_USER_DEPRECATED);
	}
}

?>