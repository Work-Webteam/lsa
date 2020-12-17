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


<h2 class="page-title">Export Recipients - <?php echo date("Y"); ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm" >

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
    var registrations=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    console.log(datestr);
    console.log(registrations);

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
                if (registrations[i].pecsf_donation) {
                    registrations[i].award = {id: 0, name: "PECSF Donation", abbreviation: "PESCF"};
                    registrations[i].award_name = registrations[i].award.name;
                }
                else {
                    registrations[i].award = {id: 0, name: "", abbreviation: ""};
                    registrations[i].award_name = registrations[i].qualifying_year + " Recipient - award received";
                }
            }
            else {
                registrations[i].award_name = registrations[i].award.name;
            }
            if (registrations[i].responded) {
                if (registrations[i].attending) {
                    registrations[i].attend_status = "Attending";
                }
                else {
                    registrations[i].attend_status = "Not Attending";
                }
            }
            else {
                registrations[i].attend_status = "No Response";
            }
            registrations[i].combined_name = registrations[i].last_name + ", " + registrations[i].first_name;

        }

        // console.log(registrations);


        $('#data-table-1').DataTable( {
            data: registrations,
            columns: [
                // {data: "last_name", title: "Last Name", orderData: [0, 1], orderSequence: ["asc"]},
                // {data: "first_name", title: "First Name", orderable: false},
                {data: "combined_name", title: "Name", orderData: [0], orderSequence: ["asc"]},
                {data: "milestone.years", title: "Milestone", orderable: false},
                {data: "office_city.name", title: "City", orderable: false},
                { data: "ceremony.date", title: "Ceremony Date", orderable: false, render: function( data, type, row, meta) {
                        const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        var d = new Date(data);
                        var formatted_date = "n/a";

                        if (!isNaN(d.getTime())) {
                            formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                        }

                        return formatted_date;
                    } },
                {data: "attend_status", title: "RSVP", orderable: false},
                {data: "ministry.name_shortform", title: "Ministry", orderable: false},
                {data: "award_name", title: "Award", orderable: false},
                {data: "admin_notes", title: "Notes", orderable: false, visible: false},



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
                        return datestr + '-nametag';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-nametag';
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

