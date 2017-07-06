<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List File Contents'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="fileContents form large-9 medium-8 columns content">
    <?= $this->Form->create($fileContent,array('type'=>'file')) ?>
    <fieldset>
        <legend><?= __('Add File Content') ?></legend>
        <?php
            //echo $this->Form->input('filename',array('type'=>'file','accept'=>'*'));
        ?>
        <input type="file" name = "filename" accept="*"/>  
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
