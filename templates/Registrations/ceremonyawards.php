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

<h2 class="page-title">Ceremony Night <?= $ceremony->night ?> - <?= date("l M j, Y g:ia", strtotime($ceremony->date)) ?></h2>
<h3>Ceremony Awards List</h3>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>
</div>


<?php
/*
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/attendingrecipients/' . $ceremony_id . '\'',
    'class' => 'btn btn-secondary',
));
*/
?>


<script>
    var registrations=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var attending=<?php echo $attending ? 1 : 0; ?>;
    var datestr="<?php echo date("Y-m", strtotime($ceremony->date)); ?>";

    console.log(attending);

    $(document).ready(function() {

        for (i = 0; i < registrations.length; i++) {
            options = JSON.parse(registrations[i].award_options)
            registrations[i].optionsDisplay = "";
            for (j = 0; j < options.length; j++) {
                if (i > 0) {
                    registrations[i].optionsDisplay += "<BR>";
                }
                registrations[i].optionsDisplay += "- " + options[j];
            }
            if (registrations[i].award_id == 0) {
                registrations[i].award = { id: 0, name: "PECSF Donation" };
            }
        }

        console.log(registrations);

        var cols;

        if (attending) {
            attendingstr = "attending";
            cols = [
                {data: "last_name", title: "Last Name"},
                {data: "first_name", title: "First Name"},
                {data: "award.name", title: "Award"},
                {data: "optionsDisplay", title: "Options"},
            ];
        }
        else {
            attendingstr = "non-attending";
            cols = [
                {data: "last_name", title: "Last Name"},
                {data: "first_name", title: "First Name"},
                {data: "award.name", title: "Award"},
                {data: "optionsDisplay", title: "Options"},
                {data: "supervisor_last_name", title: "Supervisor Last Name"},
                {data: "supervisor_first_name", title: "Supervisor First Name"},
                {data: "supervisor_email", title: "Supervisor Email"},
            ];
        }

        $('#data-table-1').DataTable( {
            data: registrations,
            columns: cols,
            // stateSave: true,
            pageLength: 15,
            pagingType: 'simple',
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-award-summary-' + attendingstr;
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-award-summary-' + attendingstr;
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

