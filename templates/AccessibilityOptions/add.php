<h1 class="page-title">Add Accessibility Requirement</h1>
<?= $this->Form->create($accessibility); ?>
<div class="form-row">
<div class="form-group">
    <?= $this->Form->control('name',['label'=>'Name of Accessibility Requirement', 'class' => 'form-control']); ?>
</div>
</div>
<?= $this->Form->button('Cancel', array('type' => 'button', 'onclick' => 'location.href=\'/accessibilityOptions\'', 'class' => 'btn btn-secondary')); ?>
<?= $this->Form->button(__('Save Accessibility Requirement'), [ 'class' => 'btn btn-primary']); ?>

<?= $this->Form->end(); ?>
