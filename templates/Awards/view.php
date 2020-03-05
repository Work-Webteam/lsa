<h1><?= h($award->name) ?></h1>
<p><?= h("Milestone: " . $milestone->name) ?></p>
<p><?= h($award->description) ?></p>
<p><?= $this->Html->image('awards/'.$award->image) ?></p>
<h2>Options</h2>
<?= $this->Html->link('Add Option', ['action' => 'addoption/'.$award->id], ['class' => 'btn btn-primary']) ?>

<table>
    <tr>
        <th>Option</th>
        <th colspan = 3>Operations</th>
        <th>Choices</th>
    </tr>

    <?php foreach ($options as $key => $option): ?>
        <tr>
            <td valign="top">
                <?= $option['name'] ?>
            </td>

            <td valign="top">
                <?= $this->Html->link('Edit',['action' => 'editoption', $award->id, $key], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td valign="top">
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'deleteoption', $award->id, $key],
                    ['confirm' => 'Are you sure?', 'class' => 'btn btn-primary', 'role' => 'button'])
                ?>
            </td>
            <td valign="top">
                <?php
                    if ($option['type'] <> 'text') {
                        echo $this->Html->link(
                            'Add Choice',
                            ['action' => 'addvalue', $award->id, $key],
                            ['class' => 'btn btn-primary', 'role' => 'button']);
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
                                <?= $this->Html->link(
                                    'Edit',
                                    ['action' => 'editvalue', $award->id, $key, $key2],
                                    ['class' => 'btn btn-primary', 'role' => 'button'])
                                ?>
                            </td>
                            <td>
                                <?= $this->Form->postLink(
                                    'Delete',
                                    ['action' => 'deletevalue', $award->id, $key, $key2],
                                    ['confirm' => 'Are you sure?', 'class' => 'btn btn-primary', 'role' => 'button'])
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
