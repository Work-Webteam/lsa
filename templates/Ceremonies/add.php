<h1 class="page-title">Add Ceremony</h1>
<?= $this->Form->create($ceremony);?>

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?= $this->Form->control('registration_year', ['label'=> 'Registration Year', 'class' => 'form-control','disabled' => true]); ?>
            <input type="hidden" name="registration_year" value="2021">
        </div>
        <div class="form-group">
            <?= $this->Form->control('night', ['label'=> 'Night Number', 'class'=> 'form-control']); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('date', ['label'=> 'Ceremony Date', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?= $this->Form->control('notes', ['type' => 'textarea', 'class' => 'form-control']); ?>
        </div>
    </div>
</div>





<?php
echo $this->Form->button(__('Save Ceremony'), array('class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/ceremonies\'',
    'class' => 'btn btn-secondary',
));
echo $this->Form->end();
?>
