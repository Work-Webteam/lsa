<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<?= $this->Html->css('lsa-datatables.css') ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<h2>Award Totals by Ceremony</h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="ceremony-accessibility" class="display ceremony-datatable" style="font-size: 12px; width:100%">

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

        console.log(recipients);

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
            ];


        $('#ceremony-accessibility').DataTable( {
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

        // btns = '<div>';
        // btns += '<button class="btn btn-primary" onClick="resetFilters()">Reset Filters</button>';
        // btns += '</div><div>';
        // // btns += '<button class="btn btn-info" onClick="dataExport()">Export</button>';
        // // btns += '&nbsp;';
        // btns += '<button class="btn btn-info" onClick="summaryAward()">Award Summary</button>';
        // btns += '&nbsp;';
        // btns += '<button class="btn btn-info" onClick="summaryMinistry()">Ministry Summary</button>';
        // btns += '&nbsp;';
        // btns += '<button class="btn btn-info" onClick="summaryMilestone()">Milestone Summary</button>';
        // btns += '</div>';
        //
        // $("div.toolbar").html(btns);


        // $("table thead th").css('border-bottom', '0px');

        // only show buttons for users with appropriate permissions
        if (!toolbar) {
            $("div.toolbar").hide();
            $(".dt-buttons").hide();
        }
    } );


    function resetFilters() {

        var table = $('#ceremony-accessibility').DataTable();

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

