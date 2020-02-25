<h1><?= h($ceremony->night) ?></h1>
<p><?= h($ceremony->id) ?></p>
<p><?= h($ceremony->date) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $ceremony->id]) ?></p>
