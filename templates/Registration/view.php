<h1><?= h($milestone->name) ?></h1>
<p><?= h($milestone->id) ?></p>
<p><?= h($milestone->donation) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $milestone->id]) ?></p>
