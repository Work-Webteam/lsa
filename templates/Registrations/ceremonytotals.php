<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<?= $this->Html->css('lsa-datatables.css') ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<h2>Long Service Awards - Totals [year]</h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="ceremony-accessibility" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>
</div>


<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\'',
    'class' => 'btn btn-secondary',
));

?>


<script>
    var totals=<?php echo json_encode($totals); ?>;
    var edit = true;
    var toolbar = true;


    $(document).ready(function() {

        console.log(totals);

        // $('#ceremony-accessibility').DataTable( {
        //     data: totals,
        //     columns: [
        //         // { data: "last_name", title: "Last Name" },
        //         // { data: "first_name", title: "First Name" },
        //         //
        //         // { data: "ceremony.night", title: "Ceremony"},
        //         // { data: "ministry.name", title: "Ministry"},
        //
        //
        //
        //     ],
        //     // stateSave: true,
        //     pageLength: 15,
        //     lengthChange: false,
        //     // order: [[ 1, "asc" ]],
        //
        //     dom: '<"toolbar">Bfrtip',
        //     buttons: [
        //         {
        //             extend: 'csv',
        //             text: 'Export to CSV',
        //             filename: function () {
        //                 return datestr + '-ceremony-diet-requirements';
        //             },
        //         },
        //         {
        //             extend: 'excel',
        //             text: 'Export to Excel',
        //             filename: function () {
        //                 return datestr + '-ceremony-diet-requirements';
        //             },
        //         }
        //     ],
        //
        //
        //     language: {
        //         search: "_INPUT_",
        //         searchPlaceholder: "Search..."
        //     },
        //
        //     initComplete: function () {
        //     }
        //
        //
        // } );

        // btns = '<div>';
        // btns += '<button class="btn btn-primary" onClick="resetFilters()">Reset Filters</button>';
        // btns += '</div><div>';
        // // btns += '<button class="btn btn-info" onClick="dataExport()">Export</button>';
        // // btns += '&nbsp;';
        // btns += '<button class="btn btn-info" onClick="summaryAward()">Award Summary</button>';
        // btns += '&nbsp;';
        // btns += '<button class="btn btn-info" onClick="summaryMinistry()">Ministry Summary</button>';
        // btns += '&nbsp;';
        // btns += '<button class="btn btn-info" onClick="summaryMilestone()">Milestone Summary</button>';
        // btns += '</div>';
        //
        // $("div.toolbar").html(btns);


        // $("table thead th").css('border-bottom', '0px');

        // only show buttons for users with appropriate permissions
        if (!toolbar) {
            $("div.toolbar").hide();
            $(".dt-buttons").hide();
        }
    } );


    function resetFilters() {

        var table = $('#ceremony-accessibility').DataTable();

        table.columns().every( function () {
            var column = this;
            $('#column-' + column.index()).prop("selectedIndex", 0);
        });
        table.search('').columns().search('').draw();
    }

    function dataExport() {
        console.log('dataExport');
    }

</script>

