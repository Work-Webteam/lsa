
<h1 class="page-title">Add Milestone</h1>
<?php
echo $this->Form->create($milestone);
// Hard code the user for now.
echo $this->Form->control('name');
echo $this->Form->control('years');
echo $this->Form->control('personalized', ['type' => 'checkbox']);
echo $this->Form->control('donation');

echo $this->Form->button(__('Save Milestone'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/milestones\'',
    'class' => 'btn btn-secondary'
]);

echo $this->Form->end();
?>
