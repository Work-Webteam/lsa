<h1>Edit User Role</h1>
<?php
echo $this->Form->create($userrole);
echo $this->Form->control('idir', ['type' => 'text', 'label' => 'IDIR']);
echo $this->Form->control('role_id');
echo $this->Form->button(__('Save User Role'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/userroles\''
));
echo $this->Form->end();
?>
