<h1><?= h($role->name) ?></h1>

<p>
    <?= $this->Html->link('Edit', ['action' => 'edit', $role->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
