<h1>Edit Diet</h1>
<?php
echo $this->Form->create($diet);
echo $this->Form->control('name');
echo $this->Form->button(__('Save Diet'));
echo $this->Form->end();
?>
