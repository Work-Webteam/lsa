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

<h2 class="page-title">Pivot Table: <?php echo $title; ?> - <?php echo date("Y"); ?></h2>


<div class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>


    <table id="data-table-2" class="table thead-dark table-striped table-sm">

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
    var totalColumns = 0;

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
                 totalColumns++;
                 cols.push({ name: "years_" + value1 + "_" + value2.years, data: "years." + value1 + "." + value2.years, title: value1 + " - " + value2.years,
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
            cols.push({ data: "years." + value1 + ".Total", title: value1 + " - Total",
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
        });
        cols.push({ data: "total", title: "Total",
            className: 'lsa-totals-column'
        });

        // console.log(cols);
        console.log("columns: " + totalColumns);


        var strFooter = "<tfoot><th></th><th></th><th></th><th></th>";
        for (var i = 0; i < totalColumns+1; i++) {
            strFooter += '<th class="lsa-totals-column"></th>';
        }
        strFooter += "</tfoot>";

        $("#data-table-1").append(strFooter);


        $('#data-table-1').DataTable( {
            data: results,
            columns: cols,
            order: [[0, 'asc']],
            rowGroup: {
                startRender: null,
                endRender: function (rows, group) {
                    var container = $('<tr/>');
                    container.append('<td colspan= "4"> Ceremony Night ' + group + ' Totals</td>');
                    var i;

                    var info = rows.data().pluck("years").toArray();

                    var totalSum = 0;
                    years.forEach(function callback(value1, index1) {
                        var yearSum = 0;
                        milestones.forEach(function callback2(value2, index2) {
                            var milestoneSum = 0
                            info.forEach(function callback3(value3, index3) {
                                milestoneSum += value3[value1][value2.years];
                                yearSum += value3[value1][value2.years];
                                totalSum += value3[value1][value2.years];
                            });
                            if (milestoneSum > 0) {
                                container.append('<td class="lsa-totals-column">' + milestoneSum + '</td>');
                            }
                            else {
                                container.append('<td></td>');
                            }
                        });
                        if (yearSum > 0) {
                            container.append('<td class="lsa-totals-column">' + yearSum + '</td>');
                        }
                        else {
                            container.append('<td></td>');
                        }

                    });
                    if (totalSum > 0) {
                        container.append('<td class="lsa-totals-column">' + totalSum + '</td>');
                    }
                    else {
                        container.append('<td></td>');
                    }
                    return $(container)

                },
                dataSrc: "ceremony_id",
            },

            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api();
                var col = 4;

              console.log("footer");
              console.log(data);

              $( api.column( 0 ).footer() ).html( 'Totals' );

              var totalSum = 0;
              years.forEach(function callback(value1, index1) {
                  var yearSum = 0;
                  milestones.forEach(function callback2(value2, index2) {
                      var milestoneSum = 0;
                      data.forEach(function callback3(value3, index3) {
                          milestoneSum += value3['years'][value1][value2.years];
                          yearSum += value3['years'][value1][value2.years];
                          totalSum += value3['years'][value1][value2.years];
                      });
                      if (milestoneSum > 0) {
                          $( api.column(col).footer() ).html( milestoneSum );
                      }
                      col++;
                  });
                  if (yearSum > 0) {
                      $(api.column(col).footer()).html(yearSum);
                  }
                  col++
              });
              if (totalSum > 0) {
                $(api.column(col).footer()).html(totalSum);
              }
            },

            // stateSave: true,
            pageLength: 15,
            pagingType: 'simple',
            lengthChange: false,

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
            pagingType: 'simple',
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

