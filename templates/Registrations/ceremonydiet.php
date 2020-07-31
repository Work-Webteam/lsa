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

<h2>Ceremony Night <?= $ceremony->night ?> - <?= date("l M j, Y g:ia", strtotime($ceremony->date)) ?></h2>
<h3>Ceremony Dietary Requirements Summary</h3>

<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="ceremony-accessibility" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>
</div>


<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/attendingrecipients/' . $ceremony_id . '\'',
    'class' => 'btn btn-secondary',
));

?>


<script>
    var registrations=<?php echo json_encode($recipients); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y-m", strtotime($ceremony->date)); ?>";


    $(document).ready(function() {

        console.log(registrations);

        $('#ceremony-accessibility').DataTable( {
            data: registrations,
            columns: [
                { data: "last_name", title: "Last Name" },
                { data: "first_name", title: "First Name" },
                // { data: "attending", title: "Attending",
                //   render: function (data, type, row) {
                //       if (type === 'display' || type === 'filter' ) {
                //           if (data == true) {
                //               return "Yes";
                //           }
                //           if (data == false) {
                //               return "No";
                //           }
                //       }
                //       return data;
                //   }
                // },
                // { data: "guest", title: "Guest",
                //   render: function (data, type, row) {
                //       if (type === 'display' || type === 'filter' ) {
                //           console.log(data);
                //          if (data == true) {
                //             return "Yes";
                //          }
                //          if (data == false) {
                //             return "No";
                //          }
                //       }
                //       return data;
                //  }
                // },

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

