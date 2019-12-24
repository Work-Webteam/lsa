<h1>PECSF Regions</h1>
<?= $this->Html->link('Add PECSF Region', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Region</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($pecsfregions as $region): ?>
        <tr>
            <td>
                <?= $region->id ?>
            </td>
            <td>
                <?= $this->Html->link($region->name, ['action' => 'view', $region->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $region->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $region->id],
                    ['confirm' => 'Are you sure?']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
