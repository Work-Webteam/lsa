<h1 class="page-title"><?= h("Ceremony Night " . $ceremony->night) ?></h1>

<p><?= h($ceremony->date) ?></p>

<p>
    <?= $this->Html->link('Add Attending', ['action' => 'addattending', $ceremony->id], ['class' => 'btn btn-primary btn-lg', 'role' => 'button']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary btn-lg', 'role' => 'button']) ?>
</p>

<table>
    <tr>
        <th colspan = 1>Ministry</th>
        <th>Milestones</th>
        <th colspan="2">City</th>
        <th>Name</th>
        <th colspan="2">Operations</th>
    </tr>

    <?php foreach ($attending as $key => $item): ?>
        <tr>
            <td valign="top">
                <?= $item['ministry_name'] ?>
            </td>
            <td valign="top">
                <?= $item['milestones'] ?>
            </td>
            <td valign="top">
                <?= $item['city_name'] ?>
            </td>
            <td valign="top">
                <?= $item['city']['id'] ? $item['city']['type'] == 0 ? 'exclude' : 'include' : "" ?>
            </td>
            <td>
                <?= isset($item['name']['start']) ? $item['name']['start'] ? $item['name']['start'] . " - " . $item['name']['end'] : "" : "" ?>
            </td>
            <td valign="top">
                <?= $this->Html->link('Edit',['action' => 'editattending', $ceremony->id, $key], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td valign="top">
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'deleteattending', $ceremony->id, $key],
                    ['confirm' => 'Are you sure?', 'class' => 'btn btn-primary', 'role' => 'button'])
                ?>
            </td>
         </tr>
    <?php endforeach; ?>
</table>
