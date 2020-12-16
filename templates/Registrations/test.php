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

<h1 class="page-title">Registrations</h1>
    <div id="container">
        <?= $this->Flash->render() ?>
        <table id="lsa-registrations" class="table thead-dark table-striped table-sm">
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
                { data: "registration_year", title: "Registration Year"},
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
            pagingType: 'simple',
            lengthChange: false,

            dom: 'Bfrtip',
            buttons: [
                'csvHtml5', 'excelHtml5'
            ],


        } );

        $("table thead tr").attr("valign", "bottom");
    } );



</script>
