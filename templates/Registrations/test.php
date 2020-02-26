<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<h1>Registrations</h1>
    <div id="container">
        <?= $this->Flash->render() ?>
        <table id="lsa-registrations" class="display" style="font-size: 12px; width:100%">
        </table>
    </div>

<script>
    var registrations=<?php echo json_encode($registrations); ?>;

    $(document).ready(function() {

        $('#lsa-registrations').DataTable( {
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

            dom: 'Bfrtip',
            buttons: [
                'csvHtml5', 'excelHtml5'
            ],


        } );

        $("table thead tr").attr("valign", "bottom");
    } );



</script>
