<h1>Error Log</h1>

<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Log</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($logs as $log): ?>
        <tr>
            <?= $isadmin ? "<td>" . $log->id . "</td>" : "" ?>
            <td>
                <?= $this->Html->link($log->timestamp, ['action' => 'view', $log->id]) ?>
            </td>
            <td>
                <?= $log->registration_id ?>
            </td>
            <td>
                <?= $log->type ?>
            </td>
            <td>
                <?= $log->operation ?>
            </td>
            <td>
                <?= $log->description ?>
            </td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $log->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
