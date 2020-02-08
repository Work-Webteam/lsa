<h1>User Roles</h1>
<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-info active']) ?>

<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-primary active']) ?>
<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-secondary active']) ?>
<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-success active']) ?>
<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-info active']) ?>
<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-warning active']) ?>
<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-danger active']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>User Id</th>
        <th>Role Id</th>
        <th colspan = 2>Operations</th>
    </tr>

    <?php foreach ($userroles as $userrole): ?>
        <tr>
            <td>
                <?= $userrole->id ?>
            </td>
            <td>
                <?= $userrole->idir ?>
            </td>
            <td>
                <?= $userrole->role->name ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $userrole->id]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
