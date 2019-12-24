<h1><?= h($role->name) ?></h1>
<p><?= h($role->id) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $role->id]) ?></p>
