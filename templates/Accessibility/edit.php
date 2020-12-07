<h1>Edit Accessibility Requirement</h1>
<?php
echo $this->Form->create($accessibility);
echo $this->Form->control('name');
echo $this->Form->control('sortorder');

echo $this->Form->button(__('Save Accessibility Requirement'), [
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
