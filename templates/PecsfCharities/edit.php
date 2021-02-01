<h1 class="page-title">Edit Charity</h1>
<?php
echo $this->Form->create($charity);
echo $this->Form->control('pecsf_region_id', ['options' => $regions]);
echo $this->Form->control('vendor_code');
echo $this->Form->control('name');
echo $this->Form->control('url');

echo $this->Form->button(__('Save PECSF Charity'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/pecsfcharities\'',
    'class' => 'btn btn-secondary'
]);

echo $this->Form->end();
?>
