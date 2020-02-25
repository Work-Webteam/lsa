<h1>Add Registration Period</h1>
<?php
echo $this->Form->create($registrationperiod);

echo $this->Form->hidden('pecsf_charity2_id', ['value' => '0']);
echo $this->Form->hidden('pecsf_amount2', ['value' => 0]);


echo $this->Form->control('award_year');
echo $this->Form->control('open_date', ['type' => 'date', 'value' => date('Y-m-d')]);
echo $this->Form->hidden('open_time', ['type' => 'time', 'value' => '00:00:00']);
echo $this->Form->control('close_date', ['type' => 'date', 'value' => date('Y-m-d')]);
echo $this->Form->hidden('close_time', ['type' => 'time', 'value' => '23:59:59']);

echo $this->Form->button(__('Save Registration Period'), array('class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrationperiods\'',
    'class' => 'btn btn-secondary',
));
echo $this->Form->end();
?>
