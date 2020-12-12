<h1>Error Log</h1>

<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Log</th>
        <th>Reg ID</th>
        <th>Type</th>
        <th>Action</th>
        <th>Description</th>
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
        </tr>
    <?php endforeach; ?>
</table>
