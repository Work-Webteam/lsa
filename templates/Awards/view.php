<h1><?= h($award->name) ?></h1>
<p><?= h($award->id) ?></p>
<p><?= h($award->milestone_id) ?></p>
<p><?= h($award->description) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $award->id]) ?></p>

<h2>Options</h2>
<?= $this->Html->link('Add Option', ['action' => 'addoption/'.$award->id], ['class' => 'btn btn-primary active']) ?>

<table>
    <tr>
        <th>Option</th>
        <th colspan = 3>Operations</th>
        <th>Values</th>
    </tr>

    <?php foreach ($options as $key => $option): ?>
        <tr>
            <td>
                <?= $option['name'] ?>
            </td>

            <td>
                <?= $this->Html->link('Edit', ['action' => 'editoption', $award->id, $key]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'deleteoption', $award->id, $key],
                    ['confirm' => 'Are you sure?'])
                ?>
                <?php
                    if ($option['type'] <> 'text') {
                        echo '| ';
                        echo $this->Html->link('Add Value', ['action' => 'addvalue', $award->id, $key]);
                    }
                ?>
            </td>

            <td>
                <table width="100%">
                    <?php foreach ($option['values'] as $key2 => $value) : ?>
                        <tr>
                            <td>
                                <?= $value ?>
                            </td>
                            <td>
                                <?= $this->Html->link('Edit', ['action' => 'editvalue', $award->id, $key, $key2]) ?> |
                                <?= $this->Form->postLink(
                                    'Delete',
                                    ['action' => 'deletevalue', $award->id, $key, $key2],
                                    ['confirm' => 'Are you sure?'])
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
