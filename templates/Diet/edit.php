<h1 class="page-title">Edit Diet</h1>
<?php
echo $this->Form->create($diet);
echo $this->Form->control('name');

echo $this->Form->button(__('Save Diet'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/diet\'',
    'class' => 'btn btn-secondary'
));

echo $this->Form->end();
?>
