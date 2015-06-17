<?php

use lithium\g11n\Message;

$t = function($message, array $options = []) {
	return Message::translate($message, $options + ['scope' => 'base_tag', 'default' => $message]);
};


$this->set([
	'page' => [
		'type' => 'multiple',
		'object' => $t('tags')
	]
]);

?>
<article
	class="use-rich-index"
	data-endpoint="<?= $this->url([
		'action' => 'index',
		'page' => '__PAGE__',
		'orderField' => '__ORDER_FIELD__',
		'orderDirection' => '__ORDER_DIRECTION__',
		'filter' => '__FILTER__'
	]) ?>"
>

	<div class="top-actions">
		<?= $this->html->link($t('delete all unused tags'), ['action' => 'clean', 'library' => 'base_tag'], ['class' => 'button delete']) ?>
		<?= $this->html->link($t('collect tags'), ['action' => 'collect', 'library' => 'base_tag'], ['class' => 'button']) ?>
		<?= $this->html->link($t('tag'), ['action' => 'add', 'library' => 'base_tag'], ['class' => 'button add']) ?>
	</div>

	<?php if ($data->count()): ?>
		<table>
			<thead>
				<tr>
					<td data-sort="is-published" class="flag is-published table-sort"><?= $t('publ.?') ?>
					<td data-sort="name" class="name emphasize table-sort asc"><?= $t('Name') ?>
					<td data-sort="title" class="title table-sort"><?= $t('Title') ?>
					<td><?= $t('# dependent') ?>
					<td data-sort="modified" class="date modified table-sort"><?= $t('Modified') ?>
					<td class="actions">
						<?= $this->form->field('search', [
							'type' => 'search',
							'label' => false,
							'placeholder' => $t('Filter'),
							'class' => 'table-search',
							'value' => $this->_request->filter
						]) ?>
			</thead>
			<tbody>
				<?php foreach ($data as $item): ?>
				<tr>
					<td class="flag is-published"><i class="material-icons"><?= ($item->is_published ? 'done' : '') ?></i>
					<td class="name emphasize"><?= $item->name ?>
					<td class="title"><?= $item->title ?: '–' ?>
					<td class="dependent"><?= ($depend = $item->depend('count')) ?: '–' ?>
					<td class="date modified">
						<time datetime="<?= $this->date->format($item->modified, 'w3c') ?>">
							<?= $this->date->format($item->modified, 'date') ?>
						</time>
					<td class="actions">
						<?= $this->html->link($t('delete'), ['id' => $item->id, 'action' => 'delete', 'library' => 'base_tag'], ['class' => 'button delete']) ?>
						<?= $this->html->link($item->is_published ? $t('unpublish') : $t('publish'), ['id' => $item->id, 'action' => $item->is_published ? 'unpublish': 'publish', 'library' => 'base_tag'], ['class' => 'button']) ?>
						<?= $this->html->link($t('open'), ['id' => $item->id, 'action' => 'edit', 'library' => 'base_tag'], ['class' => 'button']) ?>
				<?php endforeach ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="none-available"><?= $t('No items available, yet.') ?></div>
	<?php endif ?>

	<?=$this->view()->render(['element' => 'paging'], compact('paginator'), ['library' => 'base_core']) ?>
</article>