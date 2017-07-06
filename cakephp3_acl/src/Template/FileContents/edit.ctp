<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $fileContent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $fileContent->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List File Contents'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="fileContents form large-9 medium-8 columns content">
    <?= $this->Form->create($fileContent) ?>
    <fieldset>
        <legend><?= __('Edit File Content') ?></legend>
        <?php
            echo $this->Form->input('filename');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
