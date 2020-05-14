
<h1>Ceremonies</h1>
<p>NOTE: Only ceremony dates for the current award year are displayed.</p>
<?= $this->Html->link('Add Ceremony', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Award Year</th>
        <th>Ceremony Night</th>
        <th>Date</th>
        <th colspan = 3>Operations</th>
    </tr>

    <?php foreach ($ceremonies as $ceremony): ?>
        <tr>
            <?= $isadmin ? "<td>" . $ceremony->id . "</td>" : "" ?>
            <td>
                <?= $ceremony->award_year ?>
            </td>
            <td>
                <?= $this->Html->link($ceremony->night, ['action' => 'view', $ceremony->id]) ?>
            </td>
            <td>
                <?= date("D Y-M-d g:ia", strtotime($ceremony->date)) ?>
            </td>

            <td>
                <?= $this->Html->link('IDs', ['controller' => 'Registrations', 'action' => 'editpresentationids', $ceremony->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Html->link('View', ['action' => 'view', $ceremony->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $ceremony->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $ceremony->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary', 'role' => 'button']) ?>
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
