<h1>Cities</h1>
<?= $this->Html->link('Add City', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>City</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($cities as $city): ?>
        <tr>
            <td>
                <?= $city->id ?>
            </td>
            <td>
                <?= $this->Html->link($city->name, ['action' => 'view', $city->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $city->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $city->id],
                    ['confirm' => 'Are you sure?'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
