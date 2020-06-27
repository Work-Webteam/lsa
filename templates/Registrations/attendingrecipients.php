<h1>Recipients</h1>
<?= $this->Html->link('Assign Recipients', ['action' => 'assignrecipients', $ceremony_id], ['class' => 'btn btn-primary']) ?>
&nbsp;
<?= $this->Html->link('Accessibility', ['action' => 'ceremonyaccessibility', $ceremony_id], ['class' => 'btn btn-info']) ?>
&nbsp;
<?= $this->Html->link('Diet', ['action' => 'ceremonydiet', $ceremony_id], ['class' => 'btn btn-info']) ?>
&nbsp;
<?= $this->Html->link('Awards', ['action' => 'ceremonyawards', $ceremony_id], ['class' => 'btn btn-info']) ?>
&nbsp;
<?= $this->Html->link('Summary', ['action' => 'ceremonysummary', $ceremony_id], ['class' => 'btn btn-info']) ?>
<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Recipient</th>
        <th>Attending</th>
        <th>Guest</th>
        <th>Presentation #</th>
    </tr>


    <?php foreach ($recipients as $key => $recipient): ?>
    <?php
        $attendingStatus = "";
        if (!is_null($recipient->attending)) {
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

