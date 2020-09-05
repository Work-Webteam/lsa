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

<h2>VIP Report - Ceremony Night <?php echo $ceremony->night ?> - <?php echo date("l, M j, Y", strtotime($ceremony->date)); ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>


    <table id="data-table-2" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>

</div>

<div>
    Total Attending: <?= $total_guests; ?>
</div>

<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/attendingrecipients/' . $ceremony->id . '\'',
    'class' => 'btn btn-secondary',
));

?>


<script>
    var results=<?php echo json_encode($results); ?>;
    var ceremony=<?php echo json_encode($ceremony); ?>;
    var totalGuests=<?php echo json_encode($total_guests); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    console.log(datestr);
    console.log(results);
    console.log(totalGuests);

    $(document).ready(function() {



        cols = [

            { data: "vip_name", title: "Name" },
            { data: "category.name", title: "Category" },
            { data: "ministry.name_shortform", title: "Ministry", orderData: [1,3], orderSequence: ["asc"]},
            { data: "title", title: "Title" },
            { data: "guest_name", title: "Guest" },
            { data: "guest_title", title: "Title"},
        ];

        $('#data-table-1').DataTable( {
            data: results,
            columns: cols,
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
                        return datestr + '-vip-report-night-';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-vip-report-night-';
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



</script>

