<!-- File: templates/Articles/add.php -->

<h1>Add Milestone</h1>
<?php
echo $this->Form->create($milestone);
// Hard code the user for now.
echo $this->Form->control('milestone');
echo $this->Form->button(__('Save Milestone'));
echo $this->Form->end();
?>
