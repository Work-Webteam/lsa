<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<?= $this->Html->css('lsa-datatables.css') ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<h2>LSA Program Data</h2>


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
            options = JSON.parse(recipients[i].award_options)
            recipients[i].optionsDisplay = "";
            for (j = 0; j < options.length; j++) {
                if (i > 0) {
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
                { data: "ceremony.date", visible: false },
                { data: "ceremony.date", title: "Ceremony", orderable: false, orderData: [0, 2, 4, 5], render: function( data, type, row, meta) {
                        const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        var d = new Date(data);

                        let formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                        console.log(formatted_date)

                        return formatted_date;
                    } },
                { data: "ministry.name", title: "Ministry", orderable: false },
                { data: "milestone.name", title: "Milestone", orderable: false },
                { data: "last_name", title: "Last Name", orderable: false },
                { data: "first_name", title: "First Name", orderable: false },
                { data: "home_city.name", title: "Home City", orderable: false },

            ];



        $('#ceremony-accessibility').DataTable( {
            data: recipients,
            columns: cols,
            order: [[ 1, "asc" ]],

            // stateSave: true,
            pageLength: 15,
            lengthChange: false,


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return year + '-lsaProgramData';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return year + '-lsaProgramData';
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

