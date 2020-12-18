<h1 class="page-title"><?= h($acessibility->name) ?></h1>

<p>
    <?= $this->Html->link('Edit', ['action' => 'edit', $accessibility->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
