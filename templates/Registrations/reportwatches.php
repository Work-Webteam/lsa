<!-- JQuery TODO: Exterminate! -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!-- JZip -->

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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

<h2 class="page-title">Watch Report</h2>
<h4><?= $today ?></h4>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <p id="date_filter">
        <span id="date-label-from" class="date-label">Changes Since: </span><input class="date_range_filter date" type="text" id="datepicker_from" />
    </p>
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
    var fromDate;
    var indicator;
    var today;

    today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    today = yyyy + "-" + mm + "-" + dd;

    $(document).ready(function() {

        for (i = 0; i < recipients.length; i++) {
            options = JSON.parse(recipients[i].award_options)
            recipients[i].optionsDisplay = "";
            if(recipients[i].award_options.length > 0) {
                let options = JSON.parse(recipients[i].award_options);
                // We want to create a string from the options object if there is one.
                if (!$.isEmptyObject(options)) {
                    // We have an object, so lets pull out all the parts and save it to a string.
                    $.each(options, function (key, value) {
                        // Strong is here to stylize our individual strings to make them easier to read.
                        // This could also be done with a class if prefered.
                        recipients[i].optionsDisplay += "<strong>" + key + "</strong>: " + value + ". <br>";
                    });
                }
            }
            if (recipients[i].award_id == 0) {
                recipients[i].award = { id: 0, name: "PECSF Donation" };
            }
        }

        var cols;

        cols = [
            { data: "ministry.name", title: "Ministry", orderable: false},
            { data: "last_name", title: "Last Name", orderable: false},
            { data: "first_name", title: "First Name", orderable: false},
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
            pagingType: 'simple',
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

