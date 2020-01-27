<h1><?= h($registration->id) ?> - <?= h($registration->first_name) ?> <?= h($registration->last_name) ?></h1>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $registration->id]) ?></p>
