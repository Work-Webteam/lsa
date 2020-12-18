<h1 class="page-title"><?= h($ministry->name) ?></h1>
<p><?= h("Short Form: " . $ministry->name_shortform) ?></p>
<p>
    <?= $this->Html->link('Edit', ['action' => 'edit', $ministry->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
