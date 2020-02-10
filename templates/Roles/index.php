<h1>Roles</h1>
<?= $this->Html->link('Add Roles', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Roles</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($roles as $role): ?>
        <tr>
            <td>
                <?= $role->id ?>
            </td>
            <td>
                <?= $this->Html->link($role->name, ['action' => 'view', $role->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $role->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $role->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
