<h1>Edit Milestone</h1>
<?php
echo $this->Form->create($milestone);
echo $this->Form->control('name');
echo $this->Form->control('donation');
echo $this->Form->button(__('Save Milestone'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/milestones\''
));
echo $this->Form->end();
?>
