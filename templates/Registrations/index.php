<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"/>

<?= $this->Html->css('lsa-datatables.css') ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<h1>Registrations</h1>
    <div id="datatable-container">
        <?= $this->Flash->render() ?>
        <table id="lsa-registrations" class="display" style="font-size: 12px; width:100%">

        </table>
    </div>

<script>
    var registrations=<?php echo json_encode($registrations); ?>;
    var edit=<?php echo json_encode($edit); ?>;
    var toolbar=<?php echo json_encode($toolbar); ?>;

    $(document).ready(function() {

        $('#lsa-registrations').DataTable( {
            data: registrations,
            columns: [
                { data: "first_name", title: "First Name" },
                { data: "last_name", title: "Last Name" },
                { data: "ministry.name", title: "Ministry" },
                { data: "branch", title: "Branch" },
                { data: "award_year", title: "Award Year"},
                { data: "milestone.name", title: "Year of Service" },
                { data: "award.name", title: "Award", defaultContent: "PECSF Donation" },
                { data: "office_city.name", title: "Office City", visible: true },
                { data: "retroactive", title: "Retroactive", visible: true, orderable: false },
                { data: "home_city.name", title: "Home City", visible: false },
                { data: "supervisor_city.name", title: "Supervisor City", visible: false },
                { data: "preferred_email", title: "Work Email", visible: false },
                { data: "alternate_email", title: "Personal Email", visible: false },
                { data: "supervisor_email", title: "Supervisor Email", visible: false },
                { data: "id", orderable: false, render: function( data, type, row, meta) {
                        if (edit) {
                            link = '<a href="/registrations/view/' + data + '">view</a> | <a href="/registrations/edit/' + data + '">edit</a>';
                        }
                        else {
                            link = '<a href="/registrations/view/' + data + '">view</a>';
                        }
                        return link;
                    }
                }
            ],
            // stateSave: true,
            pageLength: 15,
            lengthChange: false,

            dom: '<"toolbar">Bfrtip',
            buttons: [
                'csv', 'excel'
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

                this.api().columns([2,3,5,6,7,8]).every( function () {

                    var column = this;
                    var select = $('<select id="column-' + column.index() + '"><option value=""></option></select><br>')
                        .appendTo( $('#data-column-'+column.index()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }


        } );

        btns = '<div>';
        btns += '<button class="btn btn-primary" onClick="resetFilters()">Reset Filters</button>';
        btns += '</div><div>';
        // btns += '<button class="btn btn-info" onClick="dataExport()">Export</button>';
        // btns += '&nbsp;';
        btns += '<button class="btn btn-info" onClick="summaryAward()">Award Summary</button>';
        btns += '&nbsp;';
        btns += '<button class="btn btn-info" onClick="summaryMinistry()">Ministry Summary</button>';
        btns += '</div>';

        $("div.toolbar").html(btns);

        $("table thead tr").attr("valign", "bottom");

        if (!toolbar) {
            $("div.toolbar").hide();
            $(".dt-buttons").hide();
        }
    } );


    function resetFilters() {

      var table = $('#lsa-registrations').DataTable();

      $('#column-2').prop("selectedIndex", 0);
      $('#column-3').prop("selectedIndex", 0);
      $('#column-5').prop("selectedIndex", 0);
      $('#column-6').prop("selectedIndex", 0);
      $('#column-7').prop("selectedIndex", 0);
      $('#column-8').prop("selectedIndex", 0);

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

</script>
