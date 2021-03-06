<!-- JQuery TODO: Exterminate! -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!-- JZip -->

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<!-- PDF Generation Scripts -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- Custom Miscellaneous Script-->
<script type="text/javascript" src="/js/lsa.js"></script>

<h2 class="page-title">Award Totals by Milestone</h2>
<h4><?= $today ?></h4>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <p id="date_filter">
        <span id="date-label-from" class="date-label">Changes Since: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
    </p>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>
</div>


<?php
/*
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\'',
    'class' => 'btn btn-secondary',
));
*/
?>


<script>
    var recipients=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var attending = true;
    var year =<?php echo $year; ?>;
    var fromDate;
    var indicator;
    var today;

    today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + "-" + mm + "-" + dd;

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
                {data: "lastupdate", title: "Changes", orderable: false, render: function (data, type, row, meta) {
                        indicator = "";
                        if (fromDate) {
                            if (data > fromDate) {
                                indicator = "CHANGES" ; // data;
                            }
                        }
                        return indicator;
                    } },
            ];


        var strFooter = "<tfoot><th></th><th></th><th></th><th></th><th></th></tfoot>";
        $("#data-table-1").append(strFooter);

        var dTable = $('#data-table-1').DataTable( {
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

                $( api.column( 0 ).footer() ).html( 'Totals' );

                var totalSum1 = 0;
                var totalSum2 = 0;
                var totalSum3 = 0;

                data.forEach(function callback(value1, index1) {
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
            pagingType: 'simple',
            lengthChange: false,


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    message: 'Award Totals by Milestone - ' + today,
                    filename: function () {
                        return year + '-AwardTotalsByMilestone-' + today;
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    message: 'Award Totals by Milestone - ' + today,
                    filename: function () {
                        return year + '-AwardTotalsByMilestone-' + today;
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


        $("#datepicker_from").datepicker({
            // showOn: "button",
            // buttonImage: "/img/icons/calendar.png",
            // buttonImageOnly: false,
            "onSelect": function(date) {
                fromDate = new Date(date).toISOString();
                dTable.rows().invalidate().draw();
            }
        }).keyup(function() {
            fromDate = new Date(this.value).toISOString();
            dTable.rows().invalidate().draw();
        }).next(".ui-datepicker-trigger").addClass("btn-light");

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

