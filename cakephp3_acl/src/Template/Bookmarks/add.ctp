<div class="bookmarks form large-9 medium-8 columns content">
    <?= $this->Form->create($bookmark) ?>
    <fieldset>
        <legend><?= __('Add Bookmark') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('title');
            echo $this->Form->input('description');
            echo $this->Form->input('url');
            echo $this->Form->input('tags._ids', ['options' => $tags]);
            echo $this->Form->radio(
            		'favorite_color',
            		[
            		['value' => 'r', 'text' => 'Red', 'style' => 'color:red;'],
            		['value' => 'u', 'text' => 'Blue', 'style' => 'color:blue;'],
            		['value' => 'g', 'text' => 'Green', 'style' => 'color:green;'],
            		]
            );
            $options = [
            'Value 1' => 'Label 1',
            'Value 2' => 'Label 2'
            ];
            echo $this->Form->select('field', $options, [
            		'multiple' => 'checkbox'
            		]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
