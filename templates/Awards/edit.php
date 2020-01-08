<h1>Edit Award</h1>
<?php
echo $this->Form->create($award, ['type' => 'file']);
echo $this->Form->control('name');
echo $this->Form->control('milestone_id', ['options' => $milestones]);
echo $this->Form->control('description', ['type' => 'textarea', 'rows' => '6', 'cols' => '50']);
echo $this->Html->image('awards/'.$award->image);
echo $this->Form->control('upload', ['type' => 'file']);
echo $this->Form->button(__('Save Award'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/awards\''
));


echo $this->Form->end();
?>
