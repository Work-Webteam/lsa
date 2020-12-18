
<h1 class="page-title">Add Ministry</h1>
<?php
echo $this->Form->create($ministry);
// Hard code the user for now.
echo $this->Form->control('name');
echo $this->Form->control('name_shortform', ['label' => 'Short Form Name']);
echo $this->Form->button(__('Save Ministry'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/ministries\'',
    'class' => 'btn btn-secondary'
]);

echo $this->Form->end();
?>
