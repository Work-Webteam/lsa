<h1 class="page-title">Add City</h1>
<?php
echo $this->Form->create($city);
// Hard code the user for now.
echo $this->Form->control('name');

echo $this->Form->button(__('Save City'), ['class' => 'btn btn-primary']);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/cities\'',
    'class' => 'btn btn-secondary'
]);
echo $this->Form->end();
?>
