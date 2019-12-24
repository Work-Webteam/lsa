<h1>PECSF Charities</h1>
<?= $this->Html->link('Add PECSF Charity', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Region</th>
        <th>Charity</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($charities as $charity): ?>
        <tr>
            <td>
                <?= $charity->id ?>
            </td>
            <td>
                <?= $charity->pecsf_region_id ?>
            </td>
            <td>
                <?= $this->Html->link($charity->name, ['action' => 'view', $charity->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $charity->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $charity->id],
                    ['confirm' => 'Are you sure?']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
