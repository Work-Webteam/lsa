<h2>Ceremony Night <?= $ceremony->night ?> - <?= date("l M j, Y g:ia", strtotime($ceremony->date)) ?></h2>
<h3>Attending Recipients</h3>
<?php

//echo $this->Form->button('Non-Personalized', ['type' => 'button',  'onclick' => 'updateFilter(false)', 'class' => 'btn btn-primary', 'id' => 'button-off']);

//echo $this->Form->button('Assign Recipients x', array(
//    'type' => 'button',
//    ['action' => 'assignrecipients', $ceremony_id],
//    'class' => 'btn btn-secondary',
//));

?>


<?= $this->Html->link('Assign Recipients', ['action' => 'assignrecipients', $ceremony_id], ['class' => 'btn btn-primary']) ?>
&nbsp;
<?= $this->Html->link('Accessibility', ['action' => 'ceremonyaccessibility', $ceremony_id], ['class' => 'btn btn-info']) ?>
&nbsp;
<?= $this->Html->link('Diet', ['action' => 'ceremonydiet', $ceremony_id], ['class' => 'btn btn-info']) ?>
&nbsp;
<?= $this->Html->link('Awards - Attending', ['action' => 'ceremonyawards', $ceremony_id, true], ['class' => 'btn btn-info']) ?>

<?= $this->Html->link('Awards - Not Attending', ['action' => 'ceremonyawards', $ceremony_id, false], ['class' => 'btn btn-info']) ?>

<?= $this->Html->link('Awards Summary', ['action' => 'ceremonyawardssummary', $ceremony_id, false], ['class' => 'btn btn-info']) ?>
&nbsp;
<?= $this->Html->link('Summary', ['action' => 'ceremonysummary', $ceremony_id], ['class' => 'btn btn-info']) ?>

<?= $this->Html->link('Name Badges', ['action' => 'exportnamebadges', $ceremony_id], ['class' => 'btn btn-info']) ?>

<?= $this->Html->link('Executive Name Badges', ['action' => 'exportexecutivebadges', $ceremony_id], ['class' => 'btn btn-info']) ?>

<?= $this->Html->link('Placecards', ['action' => 'exportplacecards', $ceremony_id], ['class' => 'btn btn-info']) ?>

<?= $this->Html->link('Recipient Names', ['action' => 'reportrecipientsbyceremony', $ceremony_id], ['class' => 'btn btn-info']) ?>

<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Recipient</th>
        <th>Ministry</th>
        <th>Attending</th>
        <th>Guest</th>
        <th>Presentation #</th>
    </tr>


    <?php foreach ($recipients as $key => $recipient): ?>
    <?php
        $attendingStatus = "";
        if ($recipient->responded) {
            if ($recipient->attending) {
                $attendingStatus = "Y";
            } else {
                $attendingStatus = "N";
            }
        }
        ?>
        <tr>
            <?= $isadmin ? "<td>" . $recipient->id . "</td>" : "" ?>
            <td>
                <?= $recipient->last_name . ", " . $recipient->first_name ?>
            </td>
            <td>
                <?= $recipient->ministry_id ?>
            </td>
            <td>
                <?= $attendingStatus ?>
            </td>
            <td>
                <?= $recipient->guest_first_name . " " . $recipient->guest_last_name ?>
            </td>
            <td>
               <?= $recipient->presentation_number ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php

//echo $this->Form->button(__('Save Presentation Numbers'), array('class' => 'btn btn-primary'));
//echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/ceremonies\'',
    'class' => 'btn btn-secondary',
));

echo $this->Form->end();

?>

