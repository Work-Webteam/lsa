<h1>Edit Option</h1>
<?php
echo $this->Form->create();

echo $this->Form->select('type', ['choice' => 'Multiple Choice', 'text' => 'Text'], ['default' => $type, 'disabled' => true]);
echo $this->Form->control('name', ['label' => 'Option', 'default' => $name]);

echo $this->Form->button(__('Save Option'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/awards/view/' . $award->id . '\''
));
echo $this->Form->end();
?>
