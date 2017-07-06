<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Widget'), ['action' => 'edit', $widget->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Widget'), ['action' => 'delete', $widget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $widget->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Widgets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Widget'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="widgets view large-9 medium-8 columns content">
    <h3><?= h($widget->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($widget->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Part No') ?></th>
            <td><?= h($widget->part_no) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($widget->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($widget->quantity) ?></td>
        </tr>
    </table>
</div>
