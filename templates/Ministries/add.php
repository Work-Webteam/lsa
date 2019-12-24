
<h1>Add Ministry</h1>
<?php
echo $this->Form->create($ministry);
// Hard code the user for now.
echo $this->Form->control('name');
echo $this->Form->button(__('Save Ministry'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/ministries\''
));
echo $this->Form->end();
?>
