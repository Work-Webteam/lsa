
<h1>Add User Role</h1>
<?php
echo $this->Form->create($userrole);
echo $this->Form->control('user_id', ['type' => 'text']);
echo $this->Form->control('role_id');
echo $this->Form->button(__('Save User Role'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/userroles\''
));
echo $this->Form->end();
?>
