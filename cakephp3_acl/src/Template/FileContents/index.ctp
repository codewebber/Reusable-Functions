<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New File Content'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fileContents index large-9 medium-8 columns content">
    <h3><?= __('File Contents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('filename') ?></th>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fileContents as $fileContent): ?>
            <tr>
                <td><?= h($fileContent->filename) ?></td>
                <td><?= $this->Number->format($fileContent->id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $fileContent->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $fileContent->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $fileContent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fileContent->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
