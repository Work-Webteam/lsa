<h1>Edit Ceremony</h1>
<?php
echo $this->Form->create($registrationperiod);
echo $this->Form->control('registration_year');
echo $this->Form->control('open_date', ['type' => 'date', 'value' => $registrationperiod->open_registration]);
echo $this->Form->hidden('open_time', ['value' => '00:00:00']);
echo $this->Form->control('close_date', ['type' => 'date', 'value' => $registrationperiod->close_registration]);
echo $this->Form->hidden('close_time', ['value' => '23:59:59']);

echo $this->Form->button(__('Save Registration Period'), array('class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrationperiods\'',
    'class' => 'btn btn-secondary',
));

echo $this->Form->end();
?>
