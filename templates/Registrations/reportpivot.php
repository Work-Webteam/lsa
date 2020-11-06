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

<h2>Pivot Table: <?php echo $title; ?> - <?php echo date("Y"); ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="display ceremony-datatable" style="font-size: 12px; width:100%">

    </table>


    <table id="data-table-2" class="display ceremony-datatable" style="font-size: 12px; width:100%">

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
    var results=<?php echo json_encode($results); ?>;
    var recipients=<?php echo json_encode($recipients); ?>;
    var years=<?php echo json_encode($years); ?>;
    var milestones=<?php echo json_encode($milestones); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    console.log(datestr);
    console.log(results);

    $(document).ready(function() {




        cols = [

            { data: "ceremony_id", title: "Ceremony"},
            { data: "ceremony.date", title: "Ceremony Date", orderable: false, render: function( data, type, row, meta) {
                    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday","Friday", "Saturday"];
                    const months = ["January", "February", "March","April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    var d = new Date(data);
                    var formatted_date = "n/a";

                    if (!isNaN(d.getTime())) {
                        formatted_date = days[d.getDay()] + ", " + months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                    }

                    return formatted_date;
                } },
            { data: "ministry_id", title: "Ministry ID"},
            { data: "ministry.name_shortform", title: "Ministry", orderData: [1,3], orderSequence: ["asc"]},
        ];

        years.forEach(function callback(value1, index1) {
             milestones.forEach(function callback2(value2, index2) {
                 cols.push({ data: "years." + value1 + "." + value2.years, title: value1 + " - " + value2.years});
             });
            cols.push({ data: "years." + value1 + ".Total", title: value1 + " - Total"});
        });
        cols.push({ data: "total", title: "Total"});

        $('#data-table-1').DataTable( {
            data: results,
            columns: cols,
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
                        return datestr + '-pivot-table';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-pivot-table';
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


        $('#data-table-2').DataTable( {
            data: recipients,
            columns: [
                {data: "qualifying_year", title: "Award Year", orderable: false},
                {data: "milestone.years", title: "Years of Service", orderable: false},
                {data: "last_name", title: "Last Name", orderData: [0, 1], orderSequence: ["asc"]},
                { data: "ceremony.date", title: "Ceremony Date", orderable: false, render: function( data, type, row, meta) {
                    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday","Friday", "Saturday"];
                    const months = ["January", "February", "March","April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    var d = new Date(data);
                    var formatted_date = "n/a";

                    if (!isNaN(d.getTime())) {
                        formatted_date = days[d.getDay()] + ", " + months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                    }

                    return formatted_date;
                } },
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
                        return datestr + '-pivot-table-list';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-pivot-table-list';
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

    } );



</script>

