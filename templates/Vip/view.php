<h1><?= h($vip->first_name . " " . $vip->last_name) ?></h1>

<p>
    <?= $this->Html->link('Edit', ['action' => 'edit', $vip->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
