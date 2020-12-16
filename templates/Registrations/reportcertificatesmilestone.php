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

<h2 class="page-title">25 Year Certificate Report</h2>
<h4><?= $today ?></h4>

<p id="date_filter">
    <span id="date-label-from" class="date-label">Changes Since: </span><input class="date_range_filter date" type="text" id="datepicker_from" />

</p>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>
</div>


<?php
/*
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\'',
    'class' => 'btn btn-secondary',
));
*/
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

    $(document).ready(function() {

        today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + "-" + mm + "-" + dd;

        console.log(recipients);

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

        var cols;

        cols = [
            { data: "ceremony.night", title: "Ceremony", orderData: [0, 2, 3, 4], orderable: false},
            { data: "ceremony.date", title: "Ceremony", orderable: false, render: function( data, type, row, meta) {
                    const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var d = new Date(data);

                    let formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()


                    return formatted_date;
                } },

            { data: "ministry.name", title: "Ministry", orderable: false},
            { data: "last_name", title: "Last Name", orderable: false},
            { data: "first_name", title: "First Name", orderable: false},
            { data: "certificate_name", title: "Certificate Name", orderable: false},
            { data: "attending", title: "Attending", orderable: true, render: function (data, type, row, meta) {
                    if (data) {
                        return "Attending";
                    } else {
                        return "Not Attending";
                    }
                }
            },
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
            pagingType: 'simple',
            lengthChange: false,


            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    message: '25 Year Certificate Report - ' + today,
                    filename: function () {
                        return year + '-CertificatesMilestone-' + today;
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    message: '25 Year Certificate Report - ' + today,
                    filename: function () {
                        return year + '-CertificatesMilestone-' + today;
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

