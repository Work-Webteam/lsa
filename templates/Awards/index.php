<h1>Awards</h1>
<?= $this->Html->link('Add Award', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Milestone</th>
        <th>Personalized</th>
        <th>Status</th>
        <th colspan = "3">Operations</th>
    </tr>

    <?php foreach ($awards as $award): ?>
        <tr>
            <td>
                <?= $award->id ?>
            </td>
            <td>
                <?= $award->name ?>
            </td>
            <td>
                <?= $award->milestone->name ?>
            </td>
            <td>
                <?= $award->personalized ? 'yes' : '' ?>
            </td>
            <td>
                <?= $award->active ? 'active' : 'inactive' ?>
            </td>
            <td>
                <?= $this->Html->link('View', ['action' => 'view', $award->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $award->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $award->id],
                    ['confirm' => 'Are you sure?','class' => 'btn btn-primary', 'role' => 'button'])
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php
$paginator = $this->Paginator->setTemplates([
    'number' => '<li class="page-item"><a href="{{url}}" class="page-link">{{text}}</a></li>',
    'current' => '<li class="page-item active"><a href="{{url}}" class="page-link">{{text}}</a></li>',
    'first' => '<li class="page-item"><a href="{{url}}" class="page-link">&laquo;</a></li>',
    'last' => '<li class="page-item"><a href="{{url}}" class="page-link">&raquo;</a></li>',
    'prevActive' => '<li class="page-item"><a href="{{url}}" class="page-link">&lt</a></li>',
    'nextActive' => '<li class="page-item"><a href="{{url}}" class="page-link">&gt</a></li>'
]);
?>
<nav>
    <ul class="pagination">
        <?php
        echo $paginator->first();
        if ($paginator->hasPrev()){
            echo $paginator->prev();
        }
        echo $paginator->numbers();
        if ($paginator->hasNext()){
            echo $paginator->next();
        }
        echo $paginator->last();
        ?>
    </ul>
</nav>
