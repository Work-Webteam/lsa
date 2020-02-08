<h1>Add Value</h1>
<?php
echo $this->Form->create();

echo $this->Form->control('name', ['label' => 'Value']);

echo $this->Form->button(__('Save Option Value'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/awards/view/' . $award->id . '\'',
    'class' => 'btn btn-secondary'
]);
echo $this->Form->end();
?>
