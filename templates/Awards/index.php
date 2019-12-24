<h1>Awards</h1>
<?= $this->Html->link('Add Award', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Milestone</th>
        <th>Status</th>
        <th colspan = 2>Operations</th>
    </tr>

    <?php foreach ($awards as $award): ?>
        <tr>
            <td>
                <?= $award->id ?>
            </td>
            <td>
                <?= $award->name ?>
            </td>
            <td>
                <?= $award->milestone_id ?>
            </td>
            <td>
                <?= $award->active ? 'active' : 'inactive' ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $award->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $award->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
