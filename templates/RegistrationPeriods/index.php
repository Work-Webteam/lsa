
<h1>Registration Periods</h1>

<?= $this->Html->link('Add Registration Period', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Award Year</th>
        <th>Open Date</th>
        <th>Close Date</th>
        <th colspan = 2>Operations</th>
    </tr>

    <?php foreach ($registrationperiods as $period): ?>
        <tr>
            <td>
                <?= $period->id ?>
            </td>
            <td>
                <?= $this->Html->link($period->award_year, ['action' => 'view', $period->id]) ?>
            </td>
            <td>
                <?= date("D Y-M-d g:ia", strtotime($period->open_registration)) ?>
            </td>
            <td>
                <?= date("D Y-M-d g:ia", strtotime($period->close_registration)) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $period->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $period->id],
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
