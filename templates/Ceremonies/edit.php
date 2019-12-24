<h1>Edit Ceremony</h1>
<?php
echo $this->Form->create($ceremony);
echo $this->Form->control('night');
echo $this->Form->control('date');
echo $this->Form->button(__('Save Ceremony'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/ceremonies\''
));
echo $this->Form->end();
?>
