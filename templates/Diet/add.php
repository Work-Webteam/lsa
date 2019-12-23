
<h1>Add Diet</h1>
<?php
echo $this->Form->create($diet);
// Hard code the user for now.
echo $this->Form->control('name');
echo $this->Form->button(__('Save Diet'));
echo $this->Form->end();
?>
