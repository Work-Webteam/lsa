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


<h2 class="page-title">RSVPs by Ceremony Night Report</h2>
<p>Total attending includes recipients, their guests and representatives from executive.</p>


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
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    console.log(datestr);
    console.log(ministries);

    $(document).ready(function() {

        console.log(ministries);


        $('#data-table-1').DataTable( {
            data: ministries,
            columns: [

                { data: "ceremony.night", title: "Night", orderData: [0, 4, 3]},
                { data: "ceremony.date", title: "Ceremony Date", orderable: false, render: function( data, type, row, meta) {
                        const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        const days = ["Sunday", "Monday", "Tuesday", "Wednewday", "Thursdau", "Friday", "Saturday"];
                        var d = new Date(data);

                        let formatted_date = days[d.getDay()] + ", " + months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                        return formatted_date;
                    } },
                { data: "ministry.name_shortform", title: "Ministry", orderable: false},
                { data: "attending_recipients", title: "Recipients Attending"},
                { data: "not_attending_recipients", title: "Not Attending"},
                { data: "no_response_recipients", title: "No Response"},
                { data: "attending_total", title: "Total Attending"},


            ],
            // stateSave: true,
            pageLength: 12,
            pagingType: 'simple',
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-rsvp-report';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-rsvp-report';
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

