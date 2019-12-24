
<h1>Ceremonies</h1>
<?= $this->Html->link('Add Ceremony', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Ceremony Night</th>
        <th>Date</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($ceremonies as $ceremony): ?>
        <tr>
            <td>
                <?= $ceremony->id ?>
            </td>
            <td>
                <?= $this->Html->link($ceremony->night, ['action' => 'view', $ceremony->id]) ?>
            </td>
            <td>
                <?= $ceremony->date // ->format(DATE_RFC850)?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $ceremony->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $ceremony->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
