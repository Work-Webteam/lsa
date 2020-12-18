<h1 class="page-title">PECSF Charities</h1>
<?= $this->Html->link('Add PECSF Charity', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>

<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Region</th>
        <th>Vendor</th>
        <th>Charity</th>
        <th colspan = 2>Operations</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->


    <?php foreach ($charities as $key => $charity): ?>
        <tr>
            <?= $isadmin ? "<td>" . $charity->id . "</td>" : "" ?>
            <td>
                <?= $charity->pecsfregion->name ?>
            </td>
            <td>
                <?= $charity->vendor_code ?>
            </td>
            <td>
                <?= $this->Html->link($charity->name, ['action' => 'view', $charity->id]) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $charity->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $charity->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary', 'role' => 'button']) ?>
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


<script>
    var allCharities=<?php echo json_encode($charities); ?>;

    console.log(allCharities);
    console.log(allCharities[0]['name']);
</script>
