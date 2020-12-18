<h1 class="page-title">Add Award</h1>
<?php
echo $this->Form->create($award, ['type' => 'file']);

echo $this->Form->control('name');
echo $this->Form->control('abbreviation');
echo $this->Form->control('milestone_id', ['options' => $milestones]);
echo $this->Form->control('description', ['type' => 'textarea', 'rows' => '6', 'cols' => '50']);
echo $this->Form->control('personalized', ['type' => 'checkbox']);

echo $this->Form->control('upload', ['type' => 'file']);

echo $this->Form->button(__('Save Award'), array('class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/awards\'',
    'class' => 'btn btn-secondary'
));

echo $this->Form->end();
?>
