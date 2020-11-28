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
<script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<h2>Award Totals by Milestone</h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="display ceremony-datatable" style="font-size: 12px; width:100%">

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
    var recipients=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var attending = true;
    var year =<?php echo $year; ?>;

    $(document).ready(function() {

        console.log("year: " + year);

        for (i = 0; i < recipients.length; i++) {
            options = JSON.parse(recipients[i].award_options);
            recipients[i].optionsDisplay = "";
            for (j = 0; j < options.length; j++) {
                if (i > 0) {
                    recipients[i].optionsDisplay += "<BR>";
                }
                recipients[i].optionsDisplay += "- " + options[j];
            }
        }

        console.log(recipients);

        var cols;

            cols = [
                {data: "milestone", title: "Milestone", orderData: [0, 1]},
                {data: "award", title: "Award", orderable: true},
                {data: "total", title: "Total", orderable: false, className: "lsa-totals-column"},
                {data: "attending", title: "Total Attending", orderable: false, className: "lsa-totals-column"},
                {data: "notattending", title: "Total Not Attending", orderable: false, className: "lsa-totals-column"},
            ];


        var strFooter = "<tfoot><th></th><th></th><th></th><th></th><th></th></tfoot>";
        $("#data-table-1").append(strFooter);

        $('#data-table-1').DataTable( {
            data: recipients,
            columns: cols,
            order: [[ 0, "asc" ]],
            rowGroup: {
                startRender: null,
                endRender: function (rows, group) {
                    var container = $('<tr/>');
                    container.append('<td colspan= "2"  class="lsa-totals-column-highlight">' + group + ' Totals</td>');
                    var i;

                    var totalSum = 0;
                    var totals = rows.data().pluck("total").toArray();
                    totals.forEach(function callback(value1, index1) {
                       totalSum += value1;
                    });
                    container.append('<td class="lsa-totals-column-highlight">' + totalSum + '</td>');

                    totalSum = 0;
                    totals = rows.data().pluck("attending").toArray();
                    totals.forEach(function callback(value1, index1) {
                        totalSum += value1;
                     });
                    container.append('<td class="lsa-totals-column-highlight">' + totalSum + '</td>');

                    totalSum = 0;
                    totals = rows.data().pluck("notattending").toArray();
                    totals.forEach(function callback(value1, index1) {
                        totalSum += value1;
                    });
                    container.append('<td class="lsa-totals-column-highlight">' + totalSum + '</td>');

                    return $(container)

                },
                dataSrc: "milestone",
            },

            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                var col = 4;

                console.log("footer");
                console.log(data);

                $( api.column( 0 ).footer() ).html( 'Totals' );

                var totalSum1 = 0;
                var totalSum2 = 0;
                var totalSum3 = 0;

                data.forEach(function callback(value1, index1) {
                    console.log(value1);
                    totalSum1 += value1.total;
                    totalSum2 += value1.attending;
                    totalSum3 += value1.notattending;
                });

                $( api.column( 2 ).footer() ).html( totalSum1 );
                $( api.column( 3 ).footer() ).html( totalSum2 );
                $( api.column( 4 ).footer() ).html( totalSum3 );
            },


            // stateSave: true,
            pageLength: 25,
            lengthChange: false,


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return year + '-AwardTotalsByMilestone';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return year + '-AwardTotalsByMilestone';
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

        // only show buttons for users with appropriate permissions
        if (!toolbar) {
            $("div.toolbar").hide();
            $(".dt-buttons").hide();
        }
    } );


    function resetFilters() {

        var table = $('#data-table-1').DataTable();

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

