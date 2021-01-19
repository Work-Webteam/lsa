
<h1 class="page-title">Add Ministry</h1>
<?= $this->Form->create($ministry) ?>

<div class="form-group">
    <?= $this->Form->control('name', ['label' => 'Ministry Full Name', 'class' => 'form-control']) ?>
</div>

<div class="form-group">
    <?= $this->Form->control('name_shortform', ['label' => 'Short-form Name', 'class' => 'form-control']) ?>
</div>

<?= $this->Form->button('Cancel', ['type' => 'button', 'onclick' => 'location.href=\'/ministries\'', 'class' => 'btn btn-cancel']) ?>
<?= $this->Form->button(__('Save Ministry'), ['class' => 'btn btn-primary']); ?>
<?= $this->Form->end(); ?>
