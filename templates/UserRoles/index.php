<h1>User Roles</h1>
<?= $this->Html->link('Add User Role', ['action' => 'add']) ?>
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
                <?= $userrole->role_id ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $userrole->id]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
