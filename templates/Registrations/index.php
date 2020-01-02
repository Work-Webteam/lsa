<h1>Registrations</h1>
<?php // $this->Html->link('Register', ['action' => 'register']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Created</th>
        <th>Modified</th>
        <th>User Id</th>
        <th>Milestone Id</th>
        <th>Award Id</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td>
                <?= $registration->id ?>
            </td>
            <td>
                <?= $registration->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $registration->modified->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Html->link($registration->user_id, ['action' => 'view', $registration->id]) ?>
            </td>
            <td>
                <?= $registration->milestone_id ?>
            </td>
            <td>
                <?= $registration->award_id ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $registration->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $registration->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
