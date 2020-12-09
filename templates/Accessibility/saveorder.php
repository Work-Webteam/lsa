


    <h1>Accessibility Requirements</h1>
    <?= $this->Html->link('Add Accessibility Requirement', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    <table>

        <thead>
        <tr>
            <?= $isadmin ? "<th>Id</th>" : "" ?>
            <th></th>
            <th>Accessibility Requirements</th>
            <th>Order</th>
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

    <button id="btnSaveOrder" class="btn btn-primary" type="button" onclick="saveOrder()">Save Order</button>





<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


<script type="text/javascript">

    var accessibility=<?php echo json_encode($accessibility); ?>;


    document.getElementById("btnSaveOrder").disabled =true;

    $('tbody').sortable({ handle: ".lsa-row-handle"});

    $( "tbody" ).on( "sortupdate", function( event, ui ) {
        console.log("order updated");
        document.getElementById("btnSaveOrder").disabled = false;
    } );



    function saveOrder() {
        console.log('save order');

        var selectedData = new Array();
        $('.row_position>tr').each(function() {
            selectedData.push($(this).attr("id"));
        });
        console.log(selectedData);
        document.getElementById("btnSaveOrder").disabled =true;

        $.ajax({
            url: "<?php echo $saveurl; ?>",
            type:'post',
            data: selectedData,
            success:function(){
                alert('your change successfully saved');
            }
        })

    };



</script>
