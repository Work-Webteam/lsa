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

<h2>Accessibility and Dietary Requirements - <?= date("Y") ?></h2>

    <div class="datatable-container">
        <?= $this->Flash->render() ?>
        <table id="data-table-1" class="display lsa-datatable" style="font-size: 12px; width:100%">

        </table>
    </div>


<?php

echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/\'',
    'class' => 'btn btn-secondary',
));

?>


<script>
    var registrations=<?php echo json_encode($recipients); ?>;
    var edit=<?php echo json_encode($edit); ?>;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    $(document).ready(function() {

        console.log(registrations);

        $('#data-table-1').DataTable( {
            data: registrations,
            order: [[ 1, "asc" ]],
            columns: [
                { data: "id", title: "Edit", orderable: false, render: function( data, type, row, meta) {
                        if (edit) {
                            // link = '<a href="/registrations/view/' + data + '">view</a> | <a href="/registrations/edit/' + data + '">edit</a>';
                            link = '<a class="btn btn-primary" href="/registrations/edit/' + data + '">edit</a>';
                        }
                        else {
                            link = '';
                        }
                        return link;
                    }
                },
                { data: "ceremony.night", title: "Night", orderData: [1, 5, 4]},
                { data: "ceremony.date", title: "Ceremony Date", orderable: false, render: function( data, type, row, meta) {
                        const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        const days = ["Sunday", "Monday", "Tuesday", "Wednewday", "Thursday", "Friday", "Saturday"];
                        var d = new Date(data);

                        let formatted_date = days[d.getDay()] + ", " + months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                        return formatted_date;
                    } },
                { data: "ministry.name_shortform", title: "Ministry", orderable: false},
                { data: "first_name", title: "First Name", orderData: [4, 3, 2], orderSequence: ["asc"], orderable: false},
                { data: "last_name", title: "Last Name", orderable: false},
                //{ data: "id", title: "ID", orderable: false},
                { data: "attending", title: "Attending Ceremony",
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter' ) {
                            if (data == 1) {
                                return "Yes";
                            }
                            if (data == 0) {
                                return "No";
                            }
                        }
                        return data;
                    }
                },
                // { data: "preferred_email", title: "Preferred Email", orderable: false},
                // { data: "alternate_email", title: "Preferred Email", orderable: false},
                // { data: "work_phone", title: "Work Phone", orderable: false},
                // { data: "work_extension", title: "Extension", orderable: false},
                // { data: "home_phone", title: "Home Phone", orderable: false},


                /*{ data: "report_diet", title: "Diet Requirements",
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter' ) {
                            if (data == true) {
                                return "Yes";
                            }
                            if (data == false) {
                                return "";
                            }
                        }
                        return data;
                    }
                },*/

                { data: "report_recipient_diet", title: "Recipient Dietary", orderable: false},
                { data: "dietary_recipient_other", title: "Recipient Dietary Notes", orderable: false},
                { data: "report_guest_diet", title: "Guest Dietary", orderable: false},
                { data: "dietary_guest_other", title: "Guest Dietary Notes", orderable: false},


                /*{ data: "report_access", title: "Accessibility Requirements",
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter' ) {
                            if (data == true) {
                                return "Yes";
                            }
                            if (data == false) {
                                return "";
                            }
                        }
                        return data;
                    }
                },*/

                { data: "report_recipient_access", title: "Recipient Accessibility", orderable: false},
                { data: "dietary_recipient_other", title: "Recipient Accessibility Notes", orderable: false},
                { data: "report_guest_access", title: "Guest Accessibility", orderable: false},
                { data: "dietary_guest_other", title: "Guest Accessibility Notes", orderable: false},


                { data: "report_reserved_seating", title: "Reserved Seating",
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter' ) {
                            if (data == 1) {
                                return "Yes";
                            }
                            if (data == 0) {
                                return "";
                            }
                        }
                        return data;
                    }
                },

                { data: "report_reserved_parking", title: "Reserved Parking",
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter' ) {
                            if (data == 1) {
                                return "Yes";
                            }
                            if (data == 0) {
                                return "";
                            }
                        }
                        return data;
                    }
                },

            ],
            bFilter: false,
            pageLength: 15,
            lengthChange: false,

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-special-requirements';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-special-requirements';
                    },
                },
                {
                    extend: 'pdf',
                    text: 'Export to PDF',
                    title: 'Recipient Requirements Report',
                    filename: function () {
                        return datestr + '-recipients-by-night';
                    },
                }
            ],


            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },

            initComplete: function () {
                // $('<tr id="select-filters">').appendTo( '#lsa-registrations thead' );
                // this.api().columns().every( function () {
                //     var column = this;
                //     if (column.visible()) {
                //         $('<td id="data-column-' + column.index() + '"></td>').appendTo('#data-table-1 thead');
                //     }
                // });
                // $('</tr>').appendTo( '#data-table-1 thead' );
                //
                // this.api().columns([1, 3]).every( function () {
                //
                //     var column = this;
                //     var select = $('<select id="column-' + column.index() + '"><option value=""></option></select><br>')
                //         .appendTo( $('#data-column-'+column.index()) )
                //         .on( 'change', function () {
                //             console.log('we here');
                //             var val = $.fn.dataTable.util.escapeRegex(
                //                 $(this).val()
                //             );
                //
                //             column.search(val ? '^' + val + '$' : '', true, false).draw();
                //         } );
                //
                //     column.data().unique().sort().each( function ( d, j ) {
                //         if (column.index() == 11 || column.index() == 16) {
                //             if (d === 1) {
                //                 var option = '<option value="Yes">Yes</option>';
                //             }
                //             else {
                //                 var option = '<option value="No">No</option>';
                //             }
                //
                //         }
                //         else {
                //             var option = '<option value="'+d+'">'+d+'</option>';
                //         }
                //         select.append( option );
                //     } );
                // } );
            }


        } );

        btns = '<div>';
        btns += '<button class="btn btn-primary" onClick="resetFilters()">Reset Filters</button>';
        btns += '</div>';

        $("div.toolbar").html(btns);

    } );


    function resetFilters() {

        var table = $('#data-table-1').DataTable();

        console.log("resetFilter");
        table.columns().every( function () {
            var column = this;
            $('#column-' + column.index()).prop("selectedIndex", 0);
        });
        table.search('').columns().search('').draw();
    }



</script>

