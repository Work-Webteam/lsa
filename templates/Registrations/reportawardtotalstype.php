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

<h2 class="page-title">Award Totals by Type</h2>
<h4><?= $today ?></h4>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <p id="date_filter">
        <span id="date-label-from" class="date-label">Changes Since: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
    </p>
    <table id="data-table-1" class="table thead-dark table-striped table-sm" >

    </table>
</div>


<script>

    var awards=<?php echo json_encode($awards); ?>;

    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";
    var fromDate;
    var indicator;
    var today;

    today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + "-" + mm + "-" + dd;

    console.log(datestr);
    console.log(awards);

    $(document).ready(function() {

        cols = [
            {data: "award", title: "Award", orderData: [0], orderSequence: ["asc"]},
            {data: "type", title: "Type"},
            {data: "milestone", title: "Milestone"},
            {data: "count", title: "Count", className: "lsa-totals-column"},
            {data: "lastupdate", title: "Changes", orderable: false, render: function (data, type, row, meta) {
                indicator = "";
                if (fromDate) {
                    if (data > fromDate) {
                        indicator = "CHANGED" ; // data;
                    }
                }
                return indicator;
            } },
        ];

        var dTable = $('#data-table-1').DataTable( {
            data: awards,
            columns: cols,
            // stateSave: true,
            pageLength: 50,
            pagingType: 'simple',
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            rowGroup: {
                startRender: null,
                endRender: function (rows, group) {

                    var info = rows.data().pluck("count").toArray();
                    var type = rows.data().pluck("type").toArray();
                    var totalSum = 0;
                    // var subtotal = false;


                    info.forEach(function callback(value, index) {
                        totalSum += value;
                    });

                    // type.forEach(function callback(value, index) {
                    //     if (value.length != 0) {
                    //         subtotal = true;
                    //     }
                    // });

                    var container;
                    // if (subtotal) {
                        container = $('<tr/>');
                    // }
                    // else {
                    //     container = $('<tr class="lsa-no-subtotal" />')
                    // }
                    container.append('<td colspan= "3">' + group + ' total</td>');

                    if (totalSum > 0) {
                        container.append('<td class="lsa-totals-column">' + totalSum + '</td>');
                    }
                    else {
                        container.append('<td></td>');
                    }

                    return $(container)



                },
                dataSrc: "award",
            },


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    message: 'Award Totals by Type - ' + today,
                    filename: function () {
                        return datestr + '-award-type-summary-' + today;
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    message: 'Award Totals by Type - ' + today,
                    filename: function () {
                        return datestr + '-award-type-summary-' + today;
                    },
                }
            ],


            bFilter: false,

            initComplete: function () {
            }


        } );

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



</script>

