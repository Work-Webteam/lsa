<h1>Edit Option</h1>
<?php
echo $this->Form->create();

echo $this->Form->select('type', ['choice' => 'Multiple Choice', 'text' => 'Text'], ['default' => $type, 'disabled' => true]);
echo $this->Form->control('name', ['label' => 'Option', 'default' => $name]);
echo $this->Form->control('maxlength', ['label' => 'Maximum Characters (0 = unlimited)', 'default' => $maxlength]);

echo $this->Form->button(__('Save Option'), ['class' => 'btn btn-primary']);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/awards/view/' . $award->id . '\'',
    'class' => 'btn btn-secondary'
]);

echo $this->Form->end();
?>
