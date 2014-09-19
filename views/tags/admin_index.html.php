<?php

$this->set([
	'page' => [
		'type' => 'multiple',
		'object' => $t('tags')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?> use-list">

	<div class="top-actions">
		<?= $this->html->link($t('delete all unused tags'), ['action' => 'clean', 'library' => 'base_tag'], ['class' => 'button delete']) ?>
		<?= $this->html->link($t('collect tags'), ['action' => 'collect', 'library' => 'base_tag'], ['class' => 'button']) ?>
		<?= $this->html->link($t('new tag'), ['action' => 'add', 'library' => 'base_tag'], ['class' => 'button add']) ?>
	</div>

	<?php if ($data->count()): ?>
		<table>
			<thead>
				<tr>
					<td data-sort="is-published" class="flag is-published list-sort"><?= $t('publ.?') ?>
					<td data-sort="name" class="name emphasize list-sort asc"><?= $t('Name') ?>
					<td data-sort="title" class="title list-sort"><?= $t('Title') ?>
					<td data-sort="dependent" class="dependent list-sort"><?= $t('# dependent') ?>
					<td data-sort="created" class="date created list-sort"><?= $t('Created') ?>
					<td class="actions">
						<?= $this->form->field('search', [
							'type' => 'search',
							'label' => false,
							'placeholder' => $t('Filter'),
							'class' => 'list-search'
						]) ?>
			</thead>
			<tbody class="list">
				<?php foreach ($data as $item): ?>
				<tr>
					<td class="flag is-published"><?= ($item->is_published ? '✓' : '×') ?>
					<td class="name emphasize"><?= $item->name ?>
					<td class="title"><?= $item->title ?: '–' ?>
					<td class="dependent"><?= ($depend = $item->depend('count')) ?: '–' ?>
					<td class="date created">
						<time datetime="<?= $this->date->format($item->created, 'w3c') ?>">
							<?= $this->date->format($item->created, 'date') ?>
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
</article>