<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $widget->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $widget->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Widgets'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="widgets form large-9 medium-8 columns content">
    <?= $this->Form->create($widget) ?>
    <fieldset>
        <legend><?= __('Edit Widget') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('part_no');
            echo $this->Form->input('quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
