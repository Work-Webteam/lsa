<h1>Add Categories</h1>
<?php
echo $this->Form->create($category);
// Hard code the user for now.
echo $this->Form->control('name');

echo $this->Form->button(__('Save Category'), ['class' => 'btn btn-primary']);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/categories\'',
    'class' => 'btn btn-secondary'
]);
echo $this->Form->end();
?>
