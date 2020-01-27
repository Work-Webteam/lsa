<h1>Registrations</h1>
<?php // $this->Html->link('Register', ['action' => 'register']) ?>
<table>
    <tr>
        <th>Name</th>
        <th>Ministry</th>
        <th>Award Year</th>
        <th>Milestone</th>
        <th>Award</th>
        <th>Created</th>
        <th colspan = 2>Operations</th>
        <th>Id</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td>
                <?= $registration->first_name ?> <?= $registration->last_name ?>
            </td>
            <td>
                <?= $registration->ministry->name ?>
            </td>
            <td>
                <?= $registration->award_year ?>
            </td>
            <td>
                <?= $registration->milestone->name ?>
            </td>
            <td>
                <?= isset($registration->award->name) ? $registration->award->name : "PECSF Donation" ?>
            </td>
            <td>
                <?= $registration->created->format('M d, Y') ?>
            </td>
            <td>
                <?= $this->Html->link('View', ['action' => 'view', $registration->id]) ?> |
                <?= $this->Html->link('Edit', ['action' => 'edit', $registration->id]) ?>
            </td>
            <td>
                <?= $registration->id ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
