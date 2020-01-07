<h1>Add Option</h1>
<?php
echo $this->Form->create();

echo $this->Form->select('type', ['choice' => 'Multiple Choice', 'text' => 'Text']);
echo $this->Form->control('name', ['label' => 'Option']);

echo $this->Form->button(__('Save Option'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/awards/view/' . $award->id . '\''
));
echo $this->Form->end();
?>
