<h1>Add City</h1>
<?php
echo $this->Form->create($city);
// Hard code the user for now.
echo $this->Form->control('name');
echo $this->Form->button(__('Save City'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/cities\''
));
echo $this->Form->end();
?>
