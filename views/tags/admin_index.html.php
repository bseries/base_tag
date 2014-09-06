<?php

$this->set([
	'page' => [
		'type' => 'multiple',
		'object' => $t('tags')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">

	<div class="top-actions">
		<?= $this->html->link($t('new tag'), ['action' => 'add', 'library' => 'base_tag'], ['class' => 'button add']) ?>
	</div>

	<?php if ($data->count()): ?>
		<table>
			<thead>
				<tr>
					<td class="flag"><?= $t('publ.?') ?>
					<td><?= $t('Name') ?>
					<td class="emphasize"><?= $t('Title') ?>
					<td><?= $t('# dependent') ?>
					<td class="date created"><?= $t('Created') ?>
					<td class="actions">
			</thead>
			<tbody>
				<?php foreach ($data as $item): ?>
				<tr>
					<td class="flag"><?= ($item->is_published ? '✓' : '×') ?>
					<td><?= $item->name ?>
					<td class="emphasize"><?= $item->title ?: '–' ?>
					<td><?= ($depend = $item->depend('count')) ?: '–' ?>
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