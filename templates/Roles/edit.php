<h1>Edit Role</h1>
<?php
echo $this->Form->create($role);
echo $this->Form->control('name');

echo $this->Form->button(__('Save Role'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/roles\'',
    'class' => 'btn btn-secondary'
));

echo $this->Form->end();
?>
