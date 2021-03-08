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


<h2 class="page-title">Awards Dashboard</h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
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
    // Get all recipients as object.
    var recipients=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var attending = true;
    var year =<?php echo $year; ?>;

    $(document).ready(function() {
        // Check for award options.
        for (i = 0; i < recipients.length; i++) {
            options = JSON.parse(recipients[i].award_options);
            // We want to create a string from the options object if there is one.
            recipients[i].optionsDisplay = "";
            if (!$.isEmptyObject(options)) {
                // We have an object, so lets pull out all the parts and save it to a string.
               $.each(options, function(key, value) {
                   // Strong is here to stylize our individual strings to make them easier to read.
                   // This could also be done with a class if prefered.
                    recipients[i].optionsDisplay += "<strong>" + key + "</strong>: " + value + ". <br>";
                });
            }
            // If this is a pecsf award, note that here.
            if (recipients[i].award_id == 0) {
                recipients[i].award = { id: 0, name: "PECSF Donation" };
            }
        }

       var cols;
            cols = [
                { data: "id", title: "Edit", orderable: false, render: function( data, type, row, meta) {
                        if (edit) {
                            link = '<a class="btn btn-primary" href="/registrations/edit/' + data + '">edit</a>';
                        }
                        else {
                            link = '';
                        }
                        return link;
                    }
                },
                {data: "ministry.name", title: "Ministry", orderable: false },
                {data: "last_name", title: "Last Name", orderable: false },
                {data: "first_name", title: "First Name", orderable: false },
                {data: "award.name", title: "Award", orderable: false },
                {data: "optionsDisplay", title: "Options", orderable: false },
            ];



        $('#data-table-1').DataTable( {
            data: recipients,
            columns: cols,
            // stateSave: true,
            pageLength: 7,
            pagingType: 'simple',
            lengthChange: false,
            order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return year + '-Awards';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return year + '-Awards';
                    },
                }
            ],


            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },

            initComplete: function () {
                $('<tr id="select-filters">').appendTo( '#lsa-registrations thead' );
                this.api().columns().every( function () {
                    var column = this;
                    if (column.visible()) {
                        $('<td id="data-column-' + column.index() + '"></td>').appendTo('#data-table-1 thead');
                    }
                });
                $('</tr>').appendTo( '#data-table-1 thead' );

                this.api().columns([1, 2, 6]).every( function () {

                    var column = this;
                    var select = $('<select id="column-' + column.index() + '"><option value=""></option></select><br>')
                        .appendTo( $('#data-column-'+column.index()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        var option = '<option value="'+d+'">'+d+'</option>';
                        select.append( option );
                    } );
                } );
            }


        } );

        btns = '<div>';
        btns += '<button class="btn btn-primary" onClick="resetFilters()">Reset Filters</button>';
        btns += '</div>';

        $("div.toolbar").html(btns);

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

