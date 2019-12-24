
<h1>Add Registration</h1>
<?php
echo $this->Form->create($registration);
// Hard code the user for now.
echo $this->Form->control('milestone_id', ['options' => $milestones]);
echo $this->Form->control('award_id', ['options' => $awards]);
echo $this->Form->button(__('Save Milestone'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\''
));
echo $this->Form->end();
?>
