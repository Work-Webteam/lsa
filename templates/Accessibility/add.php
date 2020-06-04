
<h1>Add Accessibility Requirement</h1>
<?php
echo $this->Form->create($accessibility);
// Hard code the user for now.
echo $this->Form->control('name');

echo $this->Form->button(__('Save Acessibility Requirement'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/accessibility\'',
    'class' => 'btn btn-secondary'
));

echo $this->Form->end();
?>
