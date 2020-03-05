<h1><?= h($milestone->name) ?></h1>

<p><?= h("Donation Amount: " . $milestone->donation) ?></p>

<p>
    <?= $this->Html->link('Edit', ['action' => 'edit', $milestone->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
