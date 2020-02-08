<h1>Edit Ministry</h1>
<?php
echo $this->Form->create($ministry);
echo $this->Form->control('name');

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
