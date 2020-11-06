<h1>Accessibility Requirements</h1>
<?= $this->Html->link('Add Accessibility Requirement', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Accessibility Requirements</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($accessibility as $item): ?>
        <tr>
            <?= $isadmin ? "<td>" . $item->id . "</td>" : "" ?>
            <td>
                <?= $this->Html->link($item->name, ['action' => 'view', $item->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $item->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $item->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
