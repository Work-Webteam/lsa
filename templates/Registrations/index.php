
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script

<h1>Registrations</h1>

    <table id="example" class="display" style="width:100%">

    </table>


<script>
    var registrations=<?php echo json_encode($registrations); ?>;

    $(document).ready(function() {
console.log(registrations);

        $('#example').DataTable( {
            data: registrations,
            columns: [
                { data: "first_name", title: "First Name" },
                { data: "last_name", title: "Last Name" },
                { data: "ministry.name", title: "Ministry" },
                { data: "department", title: "Branch" },
                { data: "award_year", title: "Award Year"},
                { data: "milestone.name", title: "Year of Service" },
                { data: "award.name", title: "Award", defaultContent: "PECSF Donation" },
                { data: "office_city.name", title: "Office City", visible: true },
                { data: "home_city.name", title: "Home City", visible: true },
                { data: "supervisor_city.name", title: "Supervisor City", visible: true },
                { data: "id", render: function( data, type, row, meta) {
                    return '<a href="/registrations/view/' + data + '">view</a>';
                    }
                }
            ],
            pageLength: 25,
            lengthChange: false,


            initComplete: function () {
                this.api().columns([2,3,5,6,7]).every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select><br>')
                        .prependTo( $(column.header()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }


        } );
    } );
</script>
