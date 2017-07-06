<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit File Content'), ['action' => 'edit', $fileContent->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete File Content'), ['action' => 'delete', $fileContent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fileContent->id)]) ?> </li>
        <li><?= $this->Html->link(__('List File Contents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New File Content'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fileContents view large-9 medium-8 columns content">
    <h3><?= h($fileContent->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Filename') ?></th>
            <td><?= h($fileContent->filename) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($fileContent->id) ?></td>
        </tr>
    </table>
</div>
