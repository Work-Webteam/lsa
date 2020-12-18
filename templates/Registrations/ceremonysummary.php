<h1 class="page-title">Ceremony Summary</h1>

<h4>Total Attendees: <?= $totals->recipients + $totals->guests; ?></h4>
<h4>Recipients: <?= $totals->recipients; ?></h4>
<h4>Guests: <?= $totals->guests; ?></h4>

<h4>Accessibility Requirements: <?= $totals->access; ?></h4>
<h5>
    <?php
            foreach ($totals->access_requirements as $item):
                echo '<div>';
                echo $item->name . ': ' .  $item->total;
                echo '</div>';
            endforeach;
    ?>
</h5>
<h5>
    <ul>
    <?php
        foreach ($totals->access_notes as $item):
            echo '<li>' . $item . '</li>';
        endforeach;
    ?>
    </ul>
</h5>
<h4>Dietary Requirements: <?= $totals->diet; ?></h4>
<h5>
    <?php
    foreach ($totals->diet_requirements as $item):
        echo '<div>';
        echo $item->name . ': ' .  $item->total;
        echo '</div>';
    endforeach;
    ?>
</h5>
<h5>
    <ul>
    <?php
    foreach ($totals->diet_notes as $item):
        echo '<li>' . $item . '</li>';
    endforeach;
    ?>
    </ul>
</h5>
<?php

//echo $this->Form->button(__('Save Presentation Numbers'), array('class' => 'btn btn-primary'));
//echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/attendingrecipients/' . $ceremony_id . '\'',
    'class' => 'btn btn-secondary',
));


?>

