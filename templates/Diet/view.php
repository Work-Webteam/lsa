<h1><?= h($diet->name) ?></h1>
<p><?= h($diet->id) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $diet->id]) ?></p>
