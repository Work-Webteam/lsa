<h1>Recipients</h1>
<?= $this->Html->link('Assign Recipients', ['action' => 'assignrecipients', $ceremony_id], ['class' => 'btn btn-primary']) ?>

<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Recipient</th>
        <th>Presentation #</th>
    </tr>


    <?php foreach ($recipients as $key => $recipient): ?>
        <tr>
            <?= $isadmin ? "<td>" . $recipient->id . "</td>" : "" ?>
            <td>
                <?= $recipient->last_name . ", " . $recipient->first_name ?>
            </td>
            <td>
                <?= $recipient->milestone_id ?>
            </td>
            <td>
               <?= $recipient->presenation_number ?>
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

