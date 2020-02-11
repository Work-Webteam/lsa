
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>

<h1>Registrations</h1>
    <div id="container">
        <?= $this->Flash->render() ?>
        <table id="example" class="display" style="width:100%">

        </table>
    </div>

<script>
    var registrations=<?php echo json_encode($registrations); ?>;

    // console.log(registrations);

    $.fn.dataTable.ext.buttons.alert = {
        className: 'buttons-alert',

        action: function ( e, dt, node, config ) {
            alert( this.text() );
        }
    };

    $(document).ready(function() {

        $('#example').DataTable( {
            data: registrations,
            columns: [
                { data: "first_name", title: "First Name" },
                { data: "last_name", title: "Last Name" },
                { data: "ministry.name", title: "Ministry" },
                { data: "branch", title: "Branch" },
                { data: "award_year", title: "Award Year"},
                { data: "milestone.name", title: "Year of Service" },
                { data: "award.name", title: "Award", defaultContent: "PECSF Donation" },
                { data: "office_city.name", title: "Office City", visible: true },
                { data: "retroactive", title: "Retroactive", visible: true },
                { data: "home_city.name", title: "Home City", visible: false },
                { data: "supervisor_city.name", title: "Supervisor City", visible: false },
                { data: "preferred_email", title: "Work Email", visible: false },
                { data: "alternate_email", title: "Personal Email", visible: false },
                { data: "supervisor_email", title: "Supervisor Email", visible: false },
                { data: "id", render: function( data, type, row, meta) {
                        return '<a href="/registrations/view/' + data + '">view</a> | <a href="/registrations/edit/' + data + '">edit</a>';
                    }
                }
            ],
            // stateSave: true,
            pageLength: 15,
            lengthChange: false,

            initComplete: function () {
                this.api().columns([2,3,5,6,7,8]).every( function () {
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
