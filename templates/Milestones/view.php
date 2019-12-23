<!-- File: templates/Articles/view.php -->

<h1><?= h($milestone->name) ?></h1>
<p><?= h($milestone->id) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $milestone->id]) ?></p>
