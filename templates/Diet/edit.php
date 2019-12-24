<h1>Edit Diet</h1>
<?php
echo $this->Form->create($diet);
echo $this->Form->control('name');
echo $this->Form->button(__('Save Diet'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/diet\''
));
echo $this->Form->end();
?>
