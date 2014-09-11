<?php

$this->set([
	'page' => [
		'type' => 'single',
		'title' => $item->name,
		'empty' => $t('unnamed'),
		'object' => $t('tag')
	],
	'meta' => [
		'is_published' => $item->is_published ? $t('published') : $t('unpublished')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<?=$this->form->create($item) ?>
		<?= $this->form->field('id', ['type' => 'hidden']) ?>

		<div class="grid-row">
			<div class="grid-column-left">
				<?= $this->form->field('name', ['type' => 'text', 'label' => $t('Name'), 'class' => 'use-for-title']) ?>
				<?= $this->form->field('title', ['type' => 'text', 'label' => $t('Title')]) ?>
			</div>
			<div class="grid-column-right">
			</div>
		</div>
		<div class="grid-row">
			<div class="grid-column-left">
				<?= $this->form->field('description', [
					'type' => 'textarea',
					'label' => $t('Description'),
					'wrap' => ['class' => 'body use-editor editor-basic editor-link']
				]) ?>
			</div>
			<div class="grid-column-right">
			</div>
		</div>
		<div class="bottom-actions">
			<?php if ($item->exists()): ?>
				<?= $this->html->link($item->is_published ? $t('unpublish') : $t('publish'), ['id' => $item->id, 'action' => $item->is_published ? 'unpublish': 'publish', 'library' => 'base_tag'], ['class' => 'button large']) ?>
			<?php endif ?>
			<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'large save']) ?>
		</div>
	<?=$this->form->end() ?>
</article>