<h1>Edit Value</h1>
<?php
echo $this->Form->create();

echo $this->Form->control('name', ['label' => 'Choice', 'default' => $name]);
echo $this->Form->button(__('Save Option Value'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/awards/view/' . $award->id . '\''
));
echo $this->Form->end();
?>
