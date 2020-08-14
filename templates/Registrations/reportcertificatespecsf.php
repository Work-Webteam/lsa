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
<h2>PECSF Donation Certificate Report</h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
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

    $(document).ready(function() {


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
            { data: "ceremony.night", title: "Ceremony", orderable: false},
            { data: "ceremony.date", title: "Ceremony", orderable: false, orderData: [0, 7, 3, 6], render: function( data, type, row, meta) {
                    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var d = new Date(data);

                    let formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()

                    return formatted_date;
                } },

            { data: "ministry.name", title: "Ministry", orderable: false},
            { data: "last_name", title: "Last Name", orderable: false},
            { data: "first_name", title: "First Name", orderable: false},
            { data: "presentation_number", title: "Presentation ID", orderable: false},
            { data: "attending", title: "Attending", orderable: false, render: function (data, type, row, meta) {
                    if (data) {
                        return "Attending";
                    } else {
                        return "Not Attending";
                    }
                }
            },

        ];


        $('#data-table-1').DataTable( {
            data: recipients,
            columns: cols,
            order: [[ 2, "asc" ]],
            // stateSave: true,
            pageLength: 15,
            lengthChange: false,


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return year + '-CertificateDonation';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return year + '-CertificateDonation';
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

