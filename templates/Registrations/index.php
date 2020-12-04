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

<h2 class="page-title">Recipients</h2>

    <div class="datatable-container">
        <?= $this->Flash->render() ?>
        <table id="lsa-registrations" class="display lsa-datatable" style="font-size: 12px; width:100%">

        </table>
    </div>

<script>
    var registrations=<?php echo json_encode($registrations); ?>;
    var edit=<?php echo json_encode($edit); ?>;
    var toolbar=<?php echo json_encode($toolbar); ?>;
    var datestr="<?php echo date("Y"); ?>";

    $(document).ready(function() {

        console.log(registrations);

        $('#lsa-registrations').DataTable( {
            data: registrations,
            order: [[ 1, "asc" ]],
            columns: [
                { data: "id", title: "Edit", orderable: false, render: function( data, type, row, meta) {
                        if (edit) {
                            // link = '<a href="/registrations/view/' + data + '">view</a> | <a href="/registrations/edit/' + data + '">edit</a>';
                            link = '<a class="btn btn-primary" href="/registrations/edit/' + data + '">edit</a>';
                        }
                        else {
                            link = '<a class="btn btn-primary" href="/registrations/view/' + data + '">view</a>';
                        }
                        return link;
                    }
                },
                { data: "last_name", title: "Last Name" },
                { data: "first_name", title: "First Name" },
                { data: "ministry.name", title: "Ministry" },
                { data: "branch", title: "Branch", orderable: false, visible: false },
                { data: "qualifying_year", title: "Award Year", orderable: true },
                { data: "milestone.name", title: "Years of Service" },
                { data: "award.name", title: "Award", defaultContent: "PECSF Donation" },
                { data: "office_city.name", title: "Office City", visible: false },
                { data: "home_city.name", title: "Home City", visible: false },
                { data: "supervisor_city.name", title: "Supervisor City", visible: false },
                { data: "retroactive", title: "Retroactive", visible: true, orderable: false,
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            if (data == true) {
                                return "Yes";
                            }
                            if (data == false) {
                                return "No";
                            }
                        }
                        return data;
                    }
                },
                { data: "preferred_email", title: "Work Email", visible: false },
                { data: "alternate_email", title: "Personal Email", visible: false },
                { data: "supervisor_email", title: "Supervisor Email", visible: false },
                { data: "award_instructions", title: "Award Instructions", visible: false, orderable: false },
                { data: "award_received", title: "Award Received", visible: true, orderable: false,
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter' ) {
                            if (data == true) {
                                return "Yes";
                            }
                            if (data == false) {
                                return "No";
                            }
                        }
                        return data;
                    },
                },
                { data: "engraving_sent", title: "Engraving Sent", visible: false, orderable: false },
                { data: "survey_participation", title: "LSA Consent", visible: false, orderable: false },
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
                        return datestr + '-registrations';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-registrations';
                    },
                }
            ],

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },

            initComplete: function () {
                $('<tr id="select-filters">').appendTo( '#lsa-registrations thead' );
                this.api().columns().every( function () {
                    var column = this;
                    if (column.visible()) {
                        $('<td id="data-column-' + column.index() + '"></td>').appendTo('#lsa-registrations thead');
                    }
                });
                $('</tr>').appendTo( '#lsa-registrations thead' );

                this.api().columns([3,6,11,16,17,18]).every( function () {

                    var column = this;
                    var select = $('<select id="column-' + column.index() + '"><option value=""></option></select><br>')
                        .appendTo( $('#data-column-'+column.index()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        if (column.index() == 11 || column.index() == 16) {
                            if (d === 1) {
                                var option = '<option value="Yes">Yes</option>';
                            }
                            else {
                                var option = '<option value="No">No</option>';
                            }

                        }
                        else {
                            var option = '<option value="'+d+'">'+d+'</option>';
                        }
                        select.append( option );
                    } );
                } );
            }


        } );

        btns = '<div>';
        btns += '<button class="btn btn-primary" onClick="resetFilters()">Reset Filters</button>';
        btns += '</div>';

        $("div.toolbar").html(btns);


        // $("table thead th").css('border-bottom', '0px');

        // only show buttons for users with appropriate permissions
        if (!toolbar) {
            $("div.toolbar").hide();
            $(".dt-buttons").hide();
        }
    } );


    function resetFilters() {

      var table = $('#lsa-registrations').DataTable();

      table.columns().every( function () {
          var column = this;
          $('#column-' + column.index()).prop("selectedIndex", 0);
      });
      table.search('').columns().search('').draw();
    }

    function dataExport() {
        console.log('dataExport');
    }

    function summaryAward() {
        location.href = "/registrations/awardsummary";
    }

    function summaryMinistry() {
        location.href = "/registrations/ministrysummary";
    }

    function summaryMilestone() {
        location.href = "/registrations/milestonesummary";
    }
</script>
