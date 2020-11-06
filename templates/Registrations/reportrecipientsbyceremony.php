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

<h2>Recipient Names by Night - <?= date("l M j, Y g:ia", strtotime($ceremony->date)) ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>
</div>


<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/attendingrecipients/' . $ceremony_id . '\'',
    'class' => 'btn btn-secondary',
));

?>


<script>
    var registrations=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y-M-d", strtotime($ceremony->date)); ?>";

    console.log(datestr);
    console.log(registrations);

    $(document).ready(function() {


        // console.log(registrations);


        $('#data-table-1').DataTable( {
            data: registrations,
            columns: [
                {data: "milestone.years", title: "Years of Service", orderable: false},
                {data: "first_name", title: "First Name", orderData: [3, 2, 1], orderSequence: ["asc"], orderable: false},
                {data: "last_name", title: "Last Name", orderable: false},
                {data: "ministry.name_shortform", title: "Ministry", orderable: false},
                {data: "office_city.name", title: "Office City", orderable: false},


            ],
            bFilter: false,
            pageLength: 15,
            lengthChange: false,
            order: [[ 1, "asc" ], [2, 'asc'], [3, 'asc']],
            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-recipients-by-night';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-recipients-by-night';
                    },
                },
                {
                    extend: 'pdf',
                    text: 'Export to PDF',
                    filename: function () {
                        return datestr + '-recipients-by-night';
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

        var table = $('#data-table-1').DataTable();

        table.columns().every( function () {
            var column = this;
            $('#column-' + column.index()).prop("selectedIndex", 0);
        });
        table.search('').columns().search('').draw();
    }



</script>

