<div id="lsa-registration-view">
    <h1><?= h($registration->first_name) ?> <?= h($registration->last_name) ?></h1>
    <h5>Employee ID: <?= h($registration->employee_id) ?></h5>
    <h5>Created: <?= h($registration->created) ?></h5>

    <div>
        <?= h($registration->milestone->name) ?>
    </div>


    <h4>Email</h4>
    <div>
        <?= h($registration->preferred_email)  ?>
    </div>
    <div>
        <?= h($registration->alternate_email)  ?>
    </div>

    <div>
        <?php
          if ($registration->retiring_this_year) {
              echo $registration->retiring_this_year ? "Retiring this year on " : "";
              echo date("M d, Y", strtotime($registration->retirement_date));
          }
        ?>
    </div>


    <h4>Office</h4>
    <div>
        <?= h($registration->office_careof)  ?>
    </div>
    <div>
        <?= h($registration->office_suite)  ?>
    </div>
    <div>
        <?= h($registration->office_address)  ?>
    </div>
    <div>
        <?= h($registration->office_city->name)  . ", " .  h($registration->office_province)  ?>
    </div>
    <div>
        <?= h($registration->work_phone) . " " . h($registration->work_extension)?>
    </div>



    <h4>Home</h4>
    <div>
        <?= h($registration->home_suite)  ?>
    </div>
    <div>
        <?= h($registration->home_address)  ?>
    </div>
    <div>
        <?= h($registration->home_city->name)  . ", " .  h($registration->home_province)  ?>
    </div>
    <div>
        <?= h($registration->home_postal_code)  ?>
    </div>
    <div>
        <?= h($registration->home_phone)  ?>
    </div>

    <h4>Supervisor</h4>
    <div>
        <?= h($registration->supervisor_first_name) .  " " . h($registration->supervisor_last_name) ?>
    </div>
    <div>
        <?= h($registration->supervisor_careof)  ?>
    </div>
    <div>
        <?= h($registration->supervisor_suite)  ?>
    </div>
    <div>
        <?= h($registration->supervisor_address)  ?>
    </div>
    <div>
        <?= h($registration->supervisor_city->name)  . ", " .  h($registration->supervisor_province)  ?>
    </div>
    <div>
        <?= h($registration->supervisor_postal_code)  ?>
    </div>
    <div>
        <?= h($registration->supervisor_email)  ?>
    </div>

    <h4>Ministry</h4>
    <div>
        <?= h("Ministry of " . $registration->ministry->name) ?>
    </div>
    <div>
        <?= h($registration->branch) ?>
    </div>

    <h4>Award</h4>
    <div>
        <?= h('Award Year: ' . h($registration->award_year)) ?>
    </div>
    <div>
        <?php
            if (is_null($registration->award)) {
                $award = new stdClass;
                $award->name = "PECSF Donation";
                $registration->award = $award;
            }
        ?>
        <?= h('Award: ' . $registration->award->name) ?>
    </div>

    <div>

            <?php
                $options = json_decode($registration->award_options, true);
                if ($options) {
                    echo "Award Options: ";
                    echo "<ul>";
                    foreach ($options as $option) {
                        $list[] = $option;
                        echo "<li>";
                        echo h($option);
                        echo "</li>";
                    }
                    echo "</ul>";
                }
            ?>
    </div>

    <div>
        <?php

            echo h('Award Received: ' . $registration->award_received)
        ?>
    </div>
    <div>
        <?= h('Watch Engraving: ' . $registration->certificate_name) ?>
    </div>
    <div>
        <?= h('Watch Engraving Sent: ') . h($registration->engraving_sent ? "Yes" : "No") ?>
    </div>
    <div>
        <?= h('Certificate Name: ' . $registration->certificate_name) ?>
    </div>
    <div>
        <?= h('Certificate Ordered: ') . h($registration->certificate_ordered ? "Yes" : "No") ?>
    </div>

    <h4>Admin</h4>
    <div>
        <?= h('LSA Survey: ') . h($registration->survey_participation ? "Yes" : "No") ?>
    </div>
    <div>
        <?= h('Date Registered: ') .  date("M d, Y", strtotime($registration->created)) ?>
    </div>
    <div>
        <?php
            if (isset($registration->created) && !is_null($registration->created)) {
                echo h('Invite Sent: ') . date("M d, Y", strtotime($registration->created));
            }
        ?>
    </div>
    <div>
        <?= h('Unique ID: ') . h($registration->id) ?>
    </div>
    <div>
        <?= h('Photo Order: ') . h($registration->photo_order) ?>
    </div>
    <div>
        <?= h('Photo Frame Range: ') . h($registration->photo_frame_range) ?>
    </div>
    <div>
        <?= h('Photo Sent: ') . h($registration->photo_sent) ?>
    </div>
    <div>
        <?= h('Notes: ') . h($registration->admin_notes) ?>
    </div>
</div>


<script>
    var registration=<?php echo json_encode($registration); ?>;

    console.log(registration);
</script>
