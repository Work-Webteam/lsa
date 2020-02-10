
<h1>Add PECSF Region</h1>
<?php
echo $this->Form->create($region);
// Hard code the user for now.
echo $this->Form->control('name');

echo $this->Form->button(__('Save PECSF Region'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/pecsfregions\'',
    'class'  => 'btn btn-secondary'
));

echo $this->Form->end();
?>
