<h1>Diet</h1>
<?= $this->Html->link('Add Diet', ['action' => 'add'], ['class' => 'btn btn-primary active']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Diet</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($diets as $diet): ?>
        <tr>
            <td>
                <?= $diet->id ?>
            </td>
            <td>
                <?= $this->Html->link($diet->name, ['action' => 'view', $diet->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $diet->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $diet->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
