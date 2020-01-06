<h1>Edit Charity</h1>
<?php
echo $this->Form->create($charity);
echo $this->Form->control('pecsf_region_id', ['options' => $regions]);
echo $this->Form->control('vendor_code');
echo $this->Form->control('name');
echo $this->Form->control('url');
echo $this->Form->button(__('Save PECSF Charity'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/pecsfcharities\''
));
echo $this->Form->end();
?>
INSERT INTO `pecsf_charities` (`pecsf_region_id`, `vendor_code`, `name`, `url`) VALUES ('
