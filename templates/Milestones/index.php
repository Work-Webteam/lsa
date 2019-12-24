<!-- File: templates/Milestones/index.php -->

<h1>Milestones</h1>
<?= $this->Html->link('Add Milestone', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Milestone</th>
        <th>Donation Amount</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($milestones as $milestone): ?>
        <tr>
            <td>
                <?= $milestone->id ?>
            </td>
            <td>
                <?= $this->Html->link($milestone->name, ['action' => 'view', $milestone->id]) ?>
            </td>
            <td>
                <?= $milestone->donation ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $milestone->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $milestone->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
