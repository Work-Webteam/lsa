<h1 class="page-title">Edit Category</h1>
<?php
echo $this->Form->create($category);
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
