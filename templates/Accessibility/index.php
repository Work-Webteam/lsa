    <h1 class="page-title">Accessibility Requirements</h1>
    <?= $this->Html->link('Add Accessibility Requirement', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    <table class="table table-striped">

        <thead>
        <tr>
            <?= $isadmin ? "<th>Id</th>" : "" ?>
            <th></th>
            <th>Accessibility Requirements</th>
            <th colspan = 2>Operations</th>
        </tr>
        </thead>

        <tbody class="row_position">

        <?php foreach ($accessibility as $item): ?>
            <tr id="<?php echo $item->id ?>">
                <?= $isadmin ? "<td>" . $item->id . "</td>" : "" ?>
                <td class="lsa-row-handle" style="cursor:move;"><i id="drag_indicator" class="material-icons">drag_indicator</i></td>
                <td>
                    <?= $this->Html->link($item->name, ['action' => 'view', $item->id]) ?>
                </td>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $item->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
                </td>
                <td>
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $item->id], ['confirm' => 'Are you sure?','class' => 'btn btn-primary delete', 'role' => 'button']) ?>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

    <button id="btnSaveOrder" class="btn btn-primary" type="button" onclick="saveOrder()">Save Order</button>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<script type="text/javascript">

    var saveurl="<?php echo $saveurl; ?>";
console.log(saveurl);
    document.getElementById("btnSaveOrder").disabled =true;

    $('tbody').sortable({ handle: ".lsa-row-handle"});

    $( "tbody" ).on( "sortupdate", function( event, ui ) {
        document.getElementById("btnSaveOrder").disabled = false;
    } );

    function saveOrder() {
        var order = new Array();

        $('.row_position>tr').each(function() {
            order.push($(this).attr("id"));
        });
        document.getElementById("btnSaveOrder").disabled =true;

        $.ajax({
            url: saveurl,
            headers: {
                'X-CSRF-Token': <?= json_encode($this->request->getAttribute('csrfToken')); ?>
            },
            type:'POST',
            data: { order : order },
            success:function(response){
            }
        })

    };

</script>
