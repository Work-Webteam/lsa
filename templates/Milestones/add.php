
<h1>Add Milestone</h1>
<?php
echo $this->Form->create($milestone);
// Hard code the user for now.
echo $this->Form->control('name');
echo $this->Form->button(__('Save Milestone'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/milestones\''
));
echo $this->Form->end();
?>
