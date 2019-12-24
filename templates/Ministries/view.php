<h1><?= h($ministry->name) ?></h1>
<p><?= h($ministry->id) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $ministry->id]) ?></p>
