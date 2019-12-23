<h1>Edit Ministry</h1>
<?php
echo $this->Form->create($ministry);
echo $this->Form->control('name');
echo $this->Form->button(__('Save Ministry'));
echo $this->Form->end();
?>
