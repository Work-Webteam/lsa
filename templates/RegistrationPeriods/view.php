<h1><?= h($period->registration_year) ?></h1>
<p><?= $period->qualifying_years ?></p>
<p><?= h("Open: " . $period->open_registration) ?></p>
<p><?= h("Close: " . $period->close_registration) ?></p>
<p>
    <?= $this->Html->link('Edit', ['action' => 'edit', $period->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>
