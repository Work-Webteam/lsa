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

<h2 class="page-title">Ceremony Night <?= $ceremony->night ?> - <?= date("l M j, Y g:ia", strtotime($ceremony->date)) ?></h2>
<h3>Ceremony Dietary Requirements Summary</h3>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>
</div>


<?php
/*
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/attendingrecipients/' . $ceremony_id . '\'',
    'class' => 'btn btn-secondary',
));
*/
?>


<script>
    var registrations=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y-m", strtotime($ceremony->date)); ?>";


    $(document).ready(function() {

        console.log(registrations);

        $('#data-table-1').DataTable( {
            data: registrations,
            columns: [
                { data: "last_name", title: "Last Name" },
                { data: "first_name", title: "First Name" },

                { data: "recipient_diet", title: "Requirements",
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
                  }
                },


                { data: "guest_last_name", title: "Last Name" },
                { data: "guest_first_name", title: "First Name" },
                { data: "guest_diet", title: "Requirements",
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
                  }
                },

                { data: "recipient_reqs", visible: false},
                { data: "guest_reqs", visible: false},
                { data: "dietary_recipient_other", visible: false},
                { data: "dietary_guest_other", visible: false},

            ],
            // stateSave: true,
            pageLength: 15,
            pagingType: 'simple',
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-ceremony-diet-requirements';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-ceremony-diet-requirements';
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

