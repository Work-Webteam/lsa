<h1>User Role</h1>
<p><?= h($userrole->idir) ?></p>
<p><?= h($userrole->role->name) ?></p>
<p>
    <?= $this->Html->link('Edit', ['action' => 'edit', $userrole->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
