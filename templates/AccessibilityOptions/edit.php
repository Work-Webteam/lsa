<h1 class="page-title">Edit Accessibility Requirement</h1>
<?= $this->Form->create($accessibilityOption); ?>

<div class="form-group">
    <label for="name">Accessibility Requirement:</label>
    <input type="text" name="name" id="name" class="form-control" value="<?= $accessibilityOption->name ?>">
</div>

<?= $this->Form->button('Cancel', array('type' => 'button', 'onclick' => 'location.href=\'/accessibilityOptions\'', 'class' => 'btn btn-secondary')); ?>
<?= $this->Form->button(__('Save Accessibility Requirement'), [ 'class' => 'btn btn-primary']); ?>
<?= $this->Form->end(); ?>
