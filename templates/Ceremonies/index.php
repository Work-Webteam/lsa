
<h1>Ceremonies</h1>
<p>NOTE: Only ceremony dates for the current year are displayed.</p>
<?= $this->Html->link('Add Ceremony', ['action' => 'add'], ['class' => 'btn btn-primary active']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Award Year</th>
        <th>Ceremony Night</th>
        <th>Date</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $ceremonies query object, printing out article info -->

    <?php foreach ($ceremonies as $ceremony): ?>
        <tr>
            <td>
                <?= $ceremony->id ?>
            </td>
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
                <?= $this->Html->link('Edit', ['action' => 'edit', $ceremony->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $ceremony->id],
                    ['confirm' => 'Are you sure?'])
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
