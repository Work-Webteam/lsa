<h1 class="page-title">System Permissions</h1>
<?= $this->Html->link('Add User', ['action' => 'add'], ['class' => 'btn btn-primary data-tables-action add-item']) ?>&nbsp;
<?= $this->Html->link('Permission Info', ['action' => 'info'], ['class' => 'btn btn-primary']) ?>
<table class="table table-striped">
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>User Id</th>
        <th>Role Id</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php foreach ($userroles as $userrole): ?>
        <tr>
            <?= $isadmin ? "<td>" . $userrole->id . "</td>" : "" ?>
            <td>
                <?= $this->Html->link($userrole->idir, ['action' => 'view', $userrole->id]) ?>
            </td>
            <td>
                <?= $userrole->role->name ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $userrole->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $userrole->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary delete', 'role' => 'button']) ?>
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
