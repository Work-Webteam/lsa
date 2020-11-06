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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<h2>Waiting List - <?php echo date("Y"); ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>
</div>


<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/\'',
    'class' => 'btn btn-secondary',
));

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
                { data: "ministry.name_shortform", title: "Ministry", orderData: [0], orderSequence: ["asc"]},
                { data: "combined_name", title: "Name", orderable: false},
                { data: "milestone.years", title: "Milestone", orderable: false},
                { data: "ceremony.date", title: "Ceremony Date", orderable: false, render: function( data, type, row, meta) {
                        const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        var d = new Date(data);
                        var formatted_date = "n/a";

                        if (!isNaN(d.getTime())) {
                            formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                        }

                        return formatted_date;
                    } },
                // {data: "attend_status", title: "Attending", orderable: false},
                {data: "award_name", title: "Award", orderable: false},


                { data: "guest", title: "Guest", orderable: false, render: function (data, type, row) {
                    if (type === 'display' || type === 'filter' ) {
                        if (data == true) {
                            return "Yes";
                        }
                        if (data == false) {
                            return "No";
                        }
                    }
                    return data;
                } },





            ],
            // stateSave: true,
            pageLength: 15,
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-waiting-list';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-waiting-list';
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

