<h1>Cities</h1>
<?= $this->Html->link('Add City', ['action' => 'add'], ['class' => 'btn btn-primary active']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>City</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($cities as $city): ?>
        <tr>
            <td>
                <?= $city->id ?>
            </td>
            <td>
                <?= $this->Html->link($city->name, ['action' => 'view', $city->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $city->id]) ?> |
                <?= $this->Form->postLink(
                    'Delete',
                    ['action' => 'delete', $city->id],
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
