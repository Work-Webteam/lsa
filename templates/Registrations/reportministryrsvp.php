<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?= $this->Html->css('lsa-datatables.css') ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<h2>Export Recipients - <?php echo date("Y"); ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="ceremony-accessibility" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>
</div>


<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/\'',
    'class' => 'btn btn-secondary',
));

?>


<script>
    var ministries=<?php echo json_encode($ministries); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    console.log(datestr);
    console.log(ministries);

    $(document).ready(function() {

        console.log(ministries);


        $('#ceremony-accessibility').DataTable( {
            data: ministries,
            columns: [
                {data: "ceremony_id", title: "Ceremony ID"},
                {data: "ministry_id", title: "Ministry ID"},
                {data: "ministry.name_shortform", title: "Ministry", orderable: false},




            ],
            // stateSave: true,
            pageLength: 15,
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-nametag';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-nametag';
                    },
                }
            ],


            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },

            initComplete: function () {
            }


        } );


    } );


    function resetFilters() {

        var table = $('#ceremony-accessibility').DataTable();

        table.columns().every( function () {
            var column = this;
            $('#column-' + column.index()).prop("selectedIndex", 0);
        });
        table.search('').columns().search('').draw();
    }



</script>

