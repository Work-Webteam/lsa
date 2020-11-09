<h1>System Permissions</h1>
<?= $this->Html->link('Add User Role', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>

<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>User Id</th>
        <th>Role Id</th>
        <th colspan = 2>Operations</th>
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
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $userrole->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary', 'role' => 'button']) ?>
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
