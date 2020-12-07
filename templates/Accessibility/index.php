<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<h1>Accessibility Requirements</h1>
<?= $this->Html->link('Add Accessibility Requirement', ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
<table>
    <tr>
        <?= $isadmin ? "<th>Id</th>" : "" ?>
        <th>Accessibility Requirements</th>
        <th>Order</th>
        <th colspan = 2>Operations</th>
    </tr>

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
</table>


<script type="text/javascript">
    $(document).ready(function(){
        $('.reorder_link').on('click',function(){
            $("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
            $('.reorder_link').html('save reordering');
            $('.reorder_link').attr("id","saveReorder");
            $('#reorderHelper').slideDown('slow');
            $('.image_link').attr("href","javascript:void(0);");
            $('.image_link').css("cursor","move");

            $("#saveReorder").click(function( e ){
                if( !$("#saveReorder i").length ){
                    $(this).html('').prepend('<img src="images/refresh-animated.gif"/>');
                    $("ul.reorder-photos-list").sortable('destroy');
                    $("#reorderHelper").html("Reordering Photos - This could take a moment. Please don't navigate away from this page.").removeClass('light_box').addClass('notice notice_error');

                    var h = [];
                    $("ul.reorder-photos-list li").each(function() {
                        h.push($(this).attr('id').substr(9));
                    });

                    $.ajax({
                        type: "POST",
                        url: "orderUpdate.php",
                        data: {ids: " " + h + ""},
                        success: function(){
                            window.location.reload();
                        }
                    });
                    return false;
                }
                e.preventDefault();
            });
        });
    });
</script>
