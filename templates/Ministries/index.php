
<h1>Ministries</h1>
<?= $this->Html->link('Add Ministry', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Ministry</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($ministries as $ministry): ?>
        <tr>
            <td>
                <?= $ministry->id ?>
            </td>
            <td>
                <?= $this->Html->link($ministry->name, ['action' => 'view', $ministry->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $ministry->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $ministry->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
