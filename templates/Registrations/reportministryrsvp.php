<!-- JQuery TODO: Exterminate! -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<!-- JZip -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"/>


<!-- PDF Generation Scripts -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- Custom Miscellaneous Script-->
<script type="text/javascript" src="/js/lsa.js"></script>


<h2 class="page-title">RSVPs by Ceremony Night Report</h2>
<p>Total attending includes recipients, their guests and representatives from executive.</p>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>
</div>


<?php
/*
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations/\'',
    'class' => 'btn btn-secondary',
));
*/
?>


<script>
    var results=<?php echo json_encode($results); ?>;
    var milestones=<?php echo json_encode($milestones); ?>;
    var edit = true;
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";
    var totalColumns = 0;

    console.log(datestr);
    console.log(results);

    $(document).ready(function() {

        cols = [

            { data: "ceremony_id", title: "Ceremony"},
            // { data: "ceremony.date", title: "Ceremony Date", orderable: false, visible: false, render: function( data, type, row, meta) {
            //         const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday","Friday", "Saturday"];
            //         const months = ["January", "February", "March","April", "May", "June", "July", "August", "September", "October", "November", "December"];
            //         var d = new Date(data);
            //         var formatted_date = "n/a";
            //
            //         if (!isNaN(d.getTime())) {
            //             formatted_date = days[d.getDay()] + ", " + months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
            //         }
            //
            //         return formatted_date;
            //     } },
            // { data: "ceremony_id", title: "Ceremony"},
            { data: "ministry.name_shortform", title: "Ministry", orderData: [0,2], orderSequence: ["asc"]},
        ];

        numStartCols = cols.length;
        console.log(numStartCols);
        milestones.forEach(function callback2(value2, index2) {
            totalColumns++;
            cols.push({ name: "years_" + value2.years, data: "years." + value2.years + ".attending", title: value2.years,
                render: function (data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        if (data > 0) {
                            return data;
                        }
                        else {
                            return "";
                        }
                    }
                    return data;
                },
                className: 'lsa-totals-column'
            });
        });

        totalColumns++;
        cols.push({ data: "years.executives.attending", title: "Executives",
            render: function (data, type, row) {
                if (type === 'display' || type === 'filter') {
                    if (data > 0) {
                        return data;
                    }
                    else {
                        return "";
                    }
                }
                return data;
            },
            className: 'lsa-totals-column'
        });

        totalColumns++;
        cols.push({ data: "years.total.attending", title: "Total",
            render: function (data, type, row) {
                if (type === 'display' || type === 'filter') {
                    if (data > 0) {
                        return data;
                    }
                    else {
                        return "";
                    }
                }
                return data;
            },
            className: 'lsa-totals-column-highlight'
        });

        // console.log("columns: " + totalColumns);


        var strFooter = "<tfoot><th>Totals</th>";

        for (var i = 0; i < numStartCols - 2; i++) {
            strFooter += "<th></th>";
        }
        for (var i = 0; i <= totalColumns; i++) {
           strFooter += '<th class="lsa-totals-column"></th>';
        }
        strFooter += "</tfoot>";
        $("#data-table-1").append(strFooter);


        $('#data-table-1').DataTable( {
            data: results,
            columns: cols,
            rowGroup: {
                startRender: function ( rows, group ) {
                    // console.log(rows);
                    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday","Friday", "Saturday"];
                    const months = ["January", "February", "March","April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    var info = rows.data().pluck("ceremony").toArray();
                    var d = new Date(info[0].date);
                    var formatted_date = "n/a";

                    if (!isNaN(d.getTime())) {
                        formatted_date = days[d.getDay()] + ", " + months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                    }
                    // console.log(formatted_date);
                    return 'Ceremony Night ' + group + ' - ' + formatted_date;
                },
                endRender: function (rows, group) {
                    var container = $('<tr/>');
                    container.append('<td colspan= "' + numStartCols +'"> Ceremony Night ' + group + ' Totals</td>');
                    var i;

                    var info = rows.data().pluck("years").toArray();

                    var totalSum = 0;
                    milestones.forEach(function callback2(value2, index2) {
                        var milestoneSum = 0
                        info.forEach(function callback3(value3, index3) {
                            milestoneSum += value3[value2.years].attending;
                            totalSum += value3[value2.years].attending;
                        });
                        if (milestoneSum > 0) {
                            container.append('<td class="lsa-totals-column">' + milestoneSum + '</td>');
                        }
                        else {
                            container.append('<td></td>');
                        }
                    });


                    var executivesSum = 0;
                    info.forEach(function callback3(value3, index3) {
                        executivesSum += value3.executives.attending;
                        totalSum += value3.executives.attending;
                    });


                    if (executivesSum > 0) {
                        container.append('<td class="lsa-totals-column">' + executivesSum + '</td>');
                    }
                    else {
                        container.append('<td></td>');
                    }

                    if (totalSum > 0) {
                        container.append('<td class="lsa-totals-column">' + totalSum + '</td>');
                    }
                    else {
                        container.append('<td></td>');
                    }
                    return $(container);

                },
                dataSrc: "ceremony_id",
            },

            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                var col = numStartCols;

                $( api.column( 0 ).footer() ).html( 'Totals' );

                var totalSum = 0;
                milestones.forEach(function callback2(value2, index2) {
                    var milestoneSum = 0;
                    data.forEach(function callback3(value3, index3) {
                        milestoneSum += value3.years[value2.years].attending;
                        totalSum += value3.years[value2.years].attending
                    });
                    if (milestoneSum > 0) {
                        $( api.column(col).footer() ).html( milestoneSum );
                    }
                    col++;
                });

                console.log(data);
                var executiveSum = 0;
                data.forEach(function callback3(value3, index3) {
                    executiveSum += value3.years.executives.attending;
                    totalSum += value3.years.executives.attending
                });
                if (executiveSum > 0) {
                    $( api.column(col).footer() ).html(executiveSum);
                }
                col++;

                if (totalSum > 0) {
                    $(api.column(col).footer()).html(totalSum);
                }
            },

            // stateSave: true,
            pageLength: 12,
            pagingType: 'simple',
            lengthChange: false,
            order: [[ 0, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-rsvp-report';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-rsvp-report';
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


    function resetFilters() {

        var table = $('#data-table-1').DataTable();

        table.columns().every( function () {
            var column = this;
            $('#column-' + column.index()).prop("selectedIndex", 0);
        });
        table.search('').columns().search('').draw();
    }



</script>

