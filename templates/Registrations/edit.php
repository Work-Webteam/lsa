<div class="container" id="app">
<h1><?= $registration->first_name . " " . $registration->last_name ?></h1>


    <ul class="nav nav-tabs" id="registrationForm">
        <li class="nav-item active"><a href="#recipient">Recipient</a></li>
        <li class="nav-item"><a href="#award">Award</a></li>
        <li class="nav-item"><a href="#office">Office</a></li>
        <li class="nav-item"><a href="#home">Home</a></li>
        <li class="nav-item"><a href="#supervisor">Supervisor</a></li>
        <li class="nav-item"><a href="#ceremony">Ceremony</a></li>
        <li class="nav-item"><a href="#admin">Admin</a></li>
    </ul>

<?php
    echo $this->Form->create($registration, ['horizontal' => true]);
?>

    <div class="tab-content">

            <div class="tab-pane active" id="recipient">
                <?php
                    echo $this->Form->control('milestone_id', ['options' => $milestones]);
                    echo $this->Form->control('employee_id', ['type' => 'text', 'label' => 'Employee ID']);
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => '- select ministry -']);
                    echo $this->Form->control('branch', ['label' => 'Branch']);
                    echo $this->Form->control('preferred_email', ['label' => 'Government Email']);
                ?>
            </div>

        <div class="tab-pane" id="award">
            <?php
            echo $this->Form->control('award_year', ['label' => 'Award Year']);
            echo $this->Form->control('award_id', ['options' => $awards]);
            echo $this->Form->control('award_received', ['type' => 'checkbox']);
            echo $this->Form->control('engraving_sent', ['type' => 'checkbox']);
            echo $this->Form->control('certificate_name');
            echo $this->Form->control('certificate_ordered');
            echo $this->Form->control('award_instructions', ['label' => 'Award Instructions', 'type' => 'textarea']);

            if ($registration->pecsf_donation) {
                echo $this->Form->control('pecsf_donation');
                echo $this->Form->control('pecsf_region_id', ['options' => $regions]);
                echo $this->Form->control('pecsf_charity1_id', ['options' => $charities]);
                echo $this->Form->control('pecsf_amount1');
                echo $this->Form->control('pecsf_second_charity');
                echo $this->Form->control('pecsf_charity2_id', ['options' => $charities]);
                echo $this->Form->control('pecsf_amount2');
                echo $this->Form->control('pecsf_cheque_date');
            }
            ?>
        </div>

            <div class="tab-pane" id="office">
                <?php
                    echo $this->Form->control('office_careof', ['label' => 'Floor/ Room / Care Of']);
                    echo $this->Form->control('office_address', ['label' => 'Address']);
                    echo $this->Form->control('office_suite', ['label' => 'Suite']);
                    echo $this->Form->control('office_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                    echo $this->Form->control('office_province', ['label' => 'Province']);
                    echo $this->Form->control('office_postal_code', ['label' => 'Postal Code']);
                    echo $this->Form->control('work_phone', ['label' => 'Phone']);
                    echo $this->Form->control('work_extension', ['label' => 'Phone Extension']);
                ?>
            </div>
            <div class="tab-pane" id="home">
                <?php
                    echo $this->Form->control('home_address', ['label' => 'Address']);
                    echo $this->Form->control('home_suite', ['label' => 'Suite']);
                    echo $this->Form->control('home_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                    echo $this->Form->control('home_province', ['label' => 'Province']);
                    echo $this->Form->control('home_postal_code', ['label' => 'Postal Code']);
                    echo $this->Form->control('home_phone', ['label' => 'Phone']);
                ?>
            </div>
            <div class="tab-pane" id="ceremony">
                    <?php
                    echo $this->Form->control('ceremony_id', ['label' => 'Ceremony Night', 'options' => $ceremonies, 'empty' => '- select ceremony -']);
//                    echo $this->Form->control('ceremony_date', ['disabled' => true]);
                    echo $this->Form->control('attending');
                    echo $this->Form->control('guest');
                    echo $this->Form->control('recipient_speaker');
                    echo $this->Form->control('reserved_seating');
                    echo $this->Form->control('executive_recipient');
                    echo $this->Form->control('presentation_number', ['label' => 'Award Presentation #']);
                    echo $this->Form->control('accessibility_requirements_recipient', ['label' => 'Recipient Accessibility Requirements', 'type' => 'checkbox']);
                    echo $this->Form->control('accessibility_requirements_guest', ['label' => 'Guest Accessibility Requirements', 'type' => 'checkbox']);
                    echo $this->Form->control('accessibility_recipient_notes');
                    echo $this->Form->control('accessibility_guest_notes');
                    echo $this->Form->control('accessibility_admin_notes');
                    echo $this->Form->control('recipient_diet_id', ['options' => $diet, 'empty' => '- select diet -']);
                    echo $this->Form->control('recipient_diet_other');
                    echo $this->Form->control('guest_diet_id', ['options' => $diet, 'empty' => '- select diet -']);
                    echo $this->Form->control('guest_diet_other');
                    ?>
            </div>
            <div class="tab-pane" id="supervisor">
                <?php
                    echo $this->Form->control('supervisor_first_name', ['label' => 'First Name']);
                    echo $this->Form->control('supervisor_last_name', ['label' => 'Last Name']);
                    echo $this->Form->control('supervisor_careof', ['label' => 'Floor / Room / Care Of']);
                    echo $this->Form->control('supervisor_address', ['label' => 'Address']);
                    echo $this->Form->control('supervisor_suite', ['label' => 'Suite']);
                    echo $this->Form->control('supervisor_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                    echo $this->Form->control('supervisor_province', ['label' => 'Province']);
                    echo $this->Form->control('supervisor_postal_code', ['label' => 'Postal Code']);
                    echo $this->Form->control('supervisor_email', ['label' => 'Email']);
                ?>
            </div>
            <div class="tab-pane" id="admin">
                <?php
                    echo $this->Form->control('survey_participation');
                    echo $this->Form->control('created', ['disabled' => true]);
                    echo $this->Form->control('invite_sent', ['type' => 'date']);
                    echo $this->Form->control('id');
                    echo $this->Form->control('photo_order');
                    echo $this->Form->control('photo_frame_range');
                    echo $this->Form->control('photo_sent', ['type' => 'date']);
                    echo $this->Form->control('admin_notes');
                ?>
            </div>
        </tabs>

    </div>
<?php
echo $this->Form->button(__('Save Registration'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\'',
    'class' => 'btn btn-secondary'
));
echo $this->Form->end();
?>
</div>


<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>

<script type="text/javascript">

    $('#registrationForm a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })

</script>
