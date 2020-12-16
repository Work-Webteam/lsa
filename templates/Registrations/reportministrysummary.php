<!-- JQuery TODO: Exterminate! -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!-- JZip -->

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

<h2 class="page-title">Milestone Totals by Ministry - <?php echo date("Y"); ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>
</div>


<?php
/*
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/\'',
    'class' => 'btn btn-secondary',
));
*/
?>


<script>

    var ministries=<?php echo json_encode($ministries); ?>;
    var milestones=<?php echo json_encode($milestones); ?>;

    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    console.log(datestr);
    console.log(ministries);

    $(document).ready(function() {

        cols = [];

        // {data: "last_name", title: "Last Name", orderData: [0, 1], orderSequence: ["asc"]},
        // {data: "first_name", title: "First Name", orderable: false},
        cols.push({data: "name_shortform", title: "Ministry", orderData: [0], orderSequence: ["asc"]});

        // milestones = JSON.parse(ministries.milestoneTotal);
        // console.log(milestones);

        cols.push({data: "milestone25", title: "25 Years", className: "lsa-totals-column"});
        cols.push({data: "milestone30", title: "30 Years", className: "lsa-totals-column"});
        cols.push({data: "milestone35", title: "35 Years", className: "lsa-totals-column"});
        cols.push({data: "milestone40", title: "40 Years", className: "lsa-totals-column"});
        cols.push({data: "milestone45", title: "45 Years", className: "lsa-totals-column"});
        cols.push({data: "milestone50", title: "50 Years", className: "lsa-totals-column"});
        cols.push({data: "total", title: "Total", className: "lsa-totals-column-highlight"});



        $('#data-table-1').DataTable( {
            data: ministries,
            columns: cols,
            // stateSave: true,
            pageLength: 50,
            pagingType: 'simple',
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-ministry-recipients';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-ministry-recipients';
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
