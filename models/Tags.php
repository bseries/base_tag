<?php
/**
 * Copyright 2014 David Persson. All rights reserved.
 * Copyright 2016 Atelier Disko. All rights reserved.
 *
 * Use of this source code is governed by a BSD-style
 * license that can be found in the LICENSE file.
 */

namespace base_tag\models;

use lithium\core\Libraries;

class Tags extends \base_core\models\Base {

	protected $_actsAs = [
		'base_core\extensions\data\behavior\Timestamp',
		'base_core\extensions\data\behavior\Searchable' => [
			'fields' => [
				'name',
				'title'
			]
		]
	];

	public static function init() {
		if (PROJECT_LOCALE !== PROJECT_LOCALES) {
			static::bindBehavior('li3_translate\extensions\data\behavior\Translatable', [
				'fields' => ['title', 'description'],
				'locale' => PROJECT_LOCALE,
				'locales' => explode(' ', PROJECT_LOCALES),
				'strategy' => 'inline'
			]);
		}
	}

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
			$results = $model::find($type, [
				'conditions' => [
					'tags' => $entity->name
				]
			]);
			if (!$results) {
				continue;
			}
			if ($type === 'count') {
				$depend += $results;
			} else {
				foreach ($results as $result) {
					$depend[] = $result;
				}
			}
		}
		return $depend;
	}

	// When no title is set falls back to name. Will strip
	// NS from name if exists.
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

Tags::init()

?>