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

<h2>Award Totals by Type - <?php echo date("Y"); ?></h2>



<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>
</div>


<script>

    var awards=<?php echo json_encode($awards); ?>;

    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    console.log(datestr);
    console.log(awards);

    $(document).ready(function() {

        cols = [];

        cols.push({data: "award", title: "Award", orderData: [0], orderSequence: ["asc"]});
        cols.push({data: "type", title: "Type"});
        cols.push({data: "milestone", title: "Milestone"});
        cols.push({data: "count", title: "Count", className: "lsa-totals-column"});


        $('#data-table-1').DataTable( {
            data: awards,
            columns: cols,
            // stateSave: true,
            pageLength: 50,
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
                    filename: function () {
                        return datestr + '-award-type-summary';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-award-type-summary';
                    },
                }
            ],


            bFilter: false,

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

