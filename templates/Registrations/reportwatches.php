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

<h2>Watch Report</h2>
<h4><?= $today ?></h4>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <p id="date_filter">
        <span id="date-label-from" class="date-label">Changes Since: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
    </p>
    <table id="data-table-1" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>
</div>


<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\'',
    'class' => 'btn btn-secondary',
));

?>


<script>
    var recipients=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var attending = true;
    var year =<?php echo $year; ?>;
    var today;
    var fromDate;
    var indicator;

    today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + "-" + mm + "-" + dd;

    $(document).ready(function() {

        console.log("year: " + year);

        for (i = 0; i < recipients.length; i++) {
            options = JSON.parse(recipients[i].award_options)
            recipients[i].optionsDisplay = "";
            console.log(options.length);
            for (var j = 0; j < options.length; j++) {
                if (j > 0) {
                    recipients[i].optionsDisplay += "<BR>";
                }
                recipients[i].optionsDisplay += "- " + options[j];
            }
            if (recipients[i].award_id == 0) {
                recipients[i].award = { id: 0, name: "PECSF Donation" };
            }
        }

        console.log(recipients);

        var cols;

        cols = [
            { data: "ceremony.night", title: "Ceremony", orderable: false,  orderData: [0, 2, 3, 4]},
            { data: "ceremony.date", title: "Ceremony", orderable: false, render: function( data, type, row, meta) {
                    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var d = new Date(data);

                    let formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()

                    return formatted_date;
                } },

            { data: "ministry.name", title: "Ministry", orderable: false},
            { data: "last_name", title: "Last Name", orderable: false},
            { data: "first_name", title: "First Name", orderable: false},
            { data: "attending", title: "Attending", orderable: false, render: function (data, type, row, meta) {
                    if (data) {
                        return "Attending";
                    } else {
                        return "Not Attending";
                    }
                }
            },
            { data: "award.name", title: "Award", orderable: false},
            { data: "optionsDisplay", title: "Options", orderable: false},
            { data: "lastupdate", title: "Changes", orderable: false, render: function (data, type, row, meta) {

                    indicator = "";
                    if (fromDate) {
                        if (data > fromDate) {
                            indicator = "CHANGED" ; // data;
                        }
                    }
                    return indicator;
                } },
        ];


        var dTable = $('#data-table-1').DataTable( {
            data: recipients,
            columns: cols,
            order: [[ 0, "asc" ]],
            // stateSave: true,
            pageLength: 15,
            lengthChange: false,


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    message: 'Watch Report - ' + today,
                    filename: function () {
                        return year + '-AwardWatches-' + today;
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    message: 'Watch Report - ' + today,
                    filename: function () {
                        return year + '-AwardWatches-' + today;
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


        // only show buttons for users with appropriate permissions
        if (!toolbar) {
            $("div.toolbar").hide();
            $(".dt-buttons").hide();
        }


        $("#datepicker_from").datepicker({
            // showOn: "button",
            // buttonImage: "/img/icons/calendar.png",
            // buttonImageOnly: false,
            "onSelect": function(date) {
                fromDate = new Date(date).toISOString();
                dTable.rows().invalidate().draw();
            }
        }).keyup(function() {
            fromDate = new Date(this.value).toISOString();
            dTable.rows().invalidate().draw();
        }).next(".ui-datepicker-trigger").addClass("btn-light");

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

