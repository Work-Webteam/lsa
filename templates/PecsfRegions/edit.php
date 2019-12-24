<h1>Edit PECSF Region</h1>
<?php
echo $this->Form->create($region);
echo $this->Form->control('name');
echo $this->Form->button(__('Save PECSF Region'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/pecsfregions\''
));
echo $this->Form->end();
?>
