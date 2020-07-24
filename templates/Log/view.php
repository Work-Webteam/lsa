<h1><?= h($log->id . " - " . $log->timestamp) ?></h1>

<p>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
