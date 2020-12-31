<!-- File: templates/Milestones/index.php -->

<h1 class="page-title">PECSF Donations</h1>
<?= $this->Html->link('Add Milestone', ['action' => 'add'], ['class' => 'btn btn-primary data-tables-action add-item']) ?>
<table class="table table-striped">
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Milestone</th>
        <th>Personalized</th>
        <th>Donation Amount</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($milestones as $milestone): ?>
        <tr>
            <?= $isadmin ? "<td>" . $milestone->id . "</td>" : "" ?>
            <td>
                <?= $this->Html->link($milestone->name, ['action' => 'view', $milestone->id]) ?>
            </td>
            <td>
                <?= $milestone->personalized ? 'yes' : '' ?>
            </td>
            <td>
                <?= $milestone->donation ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $milestone->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $milestone->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary delete', 'role' => 'button']) ?>
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
