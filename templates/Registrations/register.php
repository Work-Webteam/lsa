<script >
    $(document).ready(function(){
        $('#MyModelretiring_this_year').change(function(){
            if($(this).is(':checked')) {
                $('#MyModelBar').fadeIn();
            }
        });
</script>



<h1>Register for Long Service Award</h1>
<?php
echo $this->Form->create($registration);

echo $this->Form->radio('retiring_this_year', [['value' => 1, 'text' => 'Yes'], ['value' => 0, 'text' => 'No']]);
echo $this->Form->control('date', ['label' => 'Retirement Date', 'type' => 'date', 'value' => date('Y-m-d'), 'minYear' => date('Y'), 'maxYear' => date('Y')]);

echo $this->Form->control('milestone_id', ['options' => $milestones]);
echo $this->Form->control('award_id', ['options' => $awards]);

echo $this->Form->control('employee_id', ['label' => 'Employee ID', 'type' => 'text']);
echo $this->Form->control('first_name');
echo $this->Form->control('last_name');

echo $this->Form->control('ministry_id', ['options' => $ministries]);
echo $this->Form->control('department');

echo $this->Form->control('office_address');
echo $this->Form->control('office_city_id', ['options' => $cities]);
echo $this->Form->control('office_province', ['disabled' => true]);
echo $this->Form->control('office_postal_code');

echo $this->Form->control('home_address');
echo $this->Form->control('home_city_id', ['options' => $cities]);
echo $this->Form->control('home_province', ['disabled' => true]);
echo $this->Form->control('home_postal_code');
echo $this->Form->control('home_phone');

echo $this->Form->control('supervisor_first_name');
echo $this->Form->control('supervisor_last_name');
echo $this->Form->control('supervisor_address');
echo $this->Form->control('supervisor_city_id', ['options' => $cities]);
echo $this->Form->control('supervisor_province', ['disabled' => true]);
echo $this->Form->control('supervisor_postal_code');
echo $this->Form->control('supervisor_email');

echo $this->Form->button(__('Register'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\''
));
echo $this->Form->end();
?>
