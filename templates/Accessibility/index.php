<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


<h1>Accessibility Requirements</h1>
<?= $this->Html->link('Add Accessibility Requirement', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th></th>
        <th>Accessibility Requirements</th>
        <th>Order</th>
        <th colspan = 2>Operations</th>
    </tr>

    <tbody>
    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($accessibility as $item): ?>
        <tr>
            <?= $isadmin ? "<td>" . $item->id . "</td>" : "" ?>
            <td class="lsa-row-handle"><i id="drag_indicator" class="material-icons">drag_indicator</i></td>
            <td>
                <?= $this->Html->link($item->name, ['action' => 'view', $item->id]) ?>
            </td>
            <td>
                <?= $item->sortorder ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $item->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $item->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary', 'role' => 'button']) ?>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>


<script type="text/javascript">

    $('tbody').sortable({ handle: ".lsa-row-handle"});

    $( "tbody" ).on( "sortupdate", function( event, ui ) {
        console.log("sort update");

        
        // var queue = rjkGetQueueArray();
        // var curr = localStorage.getItem("rjkQueueIndexCurrent");
        // var currId = queue[curr].video_id;
        // var sortedIDs = $( "tbody" ).sortable( "toArray", {attribute:
        //         'value'} );
        //
        // var newQueue = [];
        // for (var idx = 0; idx < sortedIDs.length; idx++) {
        //     var idx1 = rjkFindVideo(sortedIDs[idx]);
        //     if (idx1 > -1) {
        //         newQueue.push(queue[idx1]);
        //     }
        // }
        // rjkSetQueueArray(newQueue);
        // newIdx = sortedIDs.findIndex(k => k == currId);
        // localStorage.setItem("rjkQueueSortUpdate", 1);
        // localStorage.setItem("rjkQueueIndexCurrent", newIdx);
        // rjkQueueRefresh();

    } );
</script>
