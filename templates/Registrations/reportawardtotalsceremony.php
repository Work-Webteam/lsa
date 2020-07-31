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


<h2>Award Totals by Ceremony</h2>

<p id="date_filter">
    <span id="date-label-from" class="date-label">Changes Since: </span><input class="date_range_filter date" type="text" id="datepicker_from" />

</p>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table" class="display ceremony-datatable" style="font-size: 12px; width:100%">

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
    var fromDate;
    var indicator = "what!";

    $(document).ready(function() {

        console.log("year: " + year);

        for (i = 0; i < recipients.length; i++) {
            options = JSON.parse(recipients[i].award_options);
            recipients[i].optionsDisplay = "";
            for (j = 0; j < options.length; j++) {
                if (i > 0) {
                    recipients[i].optionsDisplay += "<BR>";
                }
                recipients[i].optionsDisplay += "- " + options[j];
            }
        }

        var cols;

            cols = [
                { data: "ceremony_night", title: "Ceremony", orderData: [0, 2]},
                { data: "ceremony_date", title: "Date", orderable: false, render: function( data, type, row, meta) {
                        const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        var d = new Date(data);

                        let formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                        return formatted_date;
                    } },
                { data: "award", title: "Award", orderable: false },
                { data: "total", title: "Total", orderable: false },
                { data: "attending", title: "Total Attending", orderable: false },
                { data: "notattending", title: "Total Not Attending", orderable: false},
                // { data: "lastupdate", title: "Last Update", orderable: false},
                { data: "lastupdate", title: "Changes", orderable: false, render: function (data, type, row, meta) {

                        indicator = "";
                        if (fromDate) {
                            if (data > fromDate) {
                                indicator = "CHANGES" ; // data;
                            }
                        }
                    return indicator;
                    } }
            ];


        var dTable = $('#data-table').DataTable( {
            data: recipients,
            columns: cols,
            // order: [[ 1, "asc" ]],
            // stateSave: true,
            pageLength: 25,
            lengthChange: false,


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return year + '-AwardTotalsByCeremony';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return year + '-AwardTotalsByCeremony';
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

        $("#datepicker_from").datepicker({
            // showOn: "button",
            // buttonImage: "/img/icons/calendar.png",
            // buttonImageOnly: false,
            "onSelect": function(date) {
                console.log("here");
                fromDate = new Date(date).toISOString();
                dTable.rows().invalidate().draw();
            }
        }).keyup(function() {
            fromDate = new Date(this.value).toISOString();
            dTable.rows().invalidate().draw();
        }).next(".ui-datepicker-trigger").addClass("btn-light");

    } );




</script>

