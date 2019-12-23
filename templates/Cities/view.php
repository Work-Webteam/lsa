<h1><?= h($city->name) ?></h1>
<p><?= h($city->id) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $city->id]) ?></p>
