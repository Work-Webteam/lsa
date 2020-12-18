<h1 class="page-title">Add Option</h1>
<?php
echo $this->Form->create();

echo $this->Form->select('type', ['choice' => 'Multiple Choice', 'text' => 'Text']);
echo $this->Form->control('name', ['label' => 'Option']);
echo $this->Form->control('maxlength', ['label' => 'Maximum Characters (0 = unlimited)', 'default' => 0]);

echo $this->Form->button(__('Save Option'), ['class' => 'btn btn-primary']);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/awards/view/' . $award->id . '\'',
    'class' => 'btn btn-secondary'
]);

echo $this->Form->end();
?>
