<h1>Recipients</h1>

<?php
echo $this->Form->create($recipients);
?>


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
                <?php

                echo $this->Form->input('Registrations.' . $key . '.presentation_number', ['label' => '', 'type' => 'text', 'id' => 'recipient-'.$recipient->id, 'value' => $recipient->presentation_number]);

                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php

echo $this->Form->button(__('Save Presentation Numbers'), array('class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/ceremonies\'',
    'class' => 'btn btn-secondary',
));

echo $this->Form->end();

?>

