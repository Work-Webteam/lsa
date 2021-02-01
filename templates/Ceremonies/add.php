<h1 class="page-title">Add Ceremony</h1>
<?= $this->Form->create($ceremony);?>
//$this->Form->templates(
//    ['dateWidget' => '{{day}}{{month}}{{year}}']
//);

<div class="form-group">
    <?= $this->Form->control('registration_year', ['label'=> 'Registration Year', 'class' => 'form-control','disabled' => true]); ?>
</div>
<div class="form-group">
    <?= echo $this->Form->control('night'); ?>
</div>


<?php
echo $this->Form->control('registration_year', ['disabled' => true]);

echo $this->Form->control('ceremony_date', ['type' => 'date', 'value' => date('Y-m-d')]);
echo $this->Form->control('ceremony_time', ['type' => 'time']);
//echo $this->Form->dateTime('test', ['dataWidget' => '{{day}}{{month}}{{year}}']);
//echo $this->Form->dateTime('released', [
//    'year' => [
//        'class' => 'year-classname',
//    ],
//    'month' => [
//        'class' => 'month-class',
//        'data-type' => 'month',
//    ],
//]);
echo $this->Form->button(__('Save Ceremony'), array('class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/ceremonies\'',
    'class' => 'btn btn-secondary',
));
echo $this->Form->end();
?>
