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

<h2 class="page-title">Wait List - <?php echo date("Y"); ?></h2>


<div id="table-1" class="datatable-container">
    <?= $this->Flash->render() ?>
    <table id="data-table-1" class="table thead-dark table-striped table-sm">

    </table>

</div>
<div id="table-2" class="datatable-container">
    <table id="data-table-2" class="table thead-dark table-striped table-sm">

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
    var waiting=<?php echo json_encode($waiting); ?>;
    var recipients=<?php echo json_encode($recipients); ?>;
    var waiturl="<?php echo $waiturl; ?>";
    var toolbar = true;
    var datestr="<?php echo date("Y"); ?>";

    // console.log(datestr);
    // console.log(waiting);
    // console.log(recipients);

    $(document).ready(function() {

        $('#table-2').hide();

        for (i = 0; i < waiting.length; i++) {
            options = JSON.parse(waiting[i].award_options)
            waiting[i].optionsDisplay = "";
            for (j = 0; j < options.length; j++) {
                if (i > 0) {
                    waiting[i].optionsDisplay += "<BR>";
                }
                waiting[i].optionsDisplay += "- " + options[j];
            }
            if (waiting[i].award_id == 0) {
                if (waiting[i].pecsf_donation) {
                    waiting[i].award = {id: 0, name: "PECSF Donation", abbreviation: "PESCF"};
                    waiting[i].award_name = waiting[i].award.name;
                }
                else {
                    waiting[i].award = {id: 0, name: "", abbreviation: ""};
                    waiting[i].award_name = waiting[i].qualifying_year + " Recipient - award received";
                }
            }
            else {
                waiting[i].award_name = waiting[i].award.name;
            }
            if (waiting[i].responded) {
                if (waiting[i].attending) {
                    waiting[i].attend_status = "Attending";
                }
                else {
                    waiting[i].attend_status = "Not Attending";
                }
            }
            else {
                waiting[i].attend_status = "No Response";
            }
            waiting[i].combined_name = waiting[i].last_name + ", " + waiting[i].first_name;

        }

        for (i = 0; i < recipients.length; i++) {
            options = JSON.parse(recipients[i].award_options)
            recipients[i].optionsDisplay = "";
            for (j = 0; j < options.length; j++) {
                if (i > 0) {
                    recipients[i].optionsDisplay += "<BR>";
                }
                recipients[i].optionsDisplay += "- " + options[j];
            }
            if (recipients[i].award_id !== null) {
                if (recipients[i].award_id == 0) {
                    if (recipients[i].pecsf_donation) {
                        recipients[i].award = {id: 0, name: "PECSF Donation", abbreviation: "PESCF"};
                        recipients[i].award_name = recipients[i].award.name;
                    } else {
                        recipients[i].award = {id: 0, name: "", abbreviation: ""};
                        recipients[i].award_name = recipients[i].qualifying_year + " Recipient - award received";
                    }
                } else {
                    recipients[i].award_name = recipients[i].award.name;
                }
            }
            else {
                recipients[i].award_name = "n/a";
            }


            recipients[i].combined_name = recipients[i].last_name + ", " + recipients[i].first_name;

        }

        // console.log(waiting);


        $('#data-table-1').DataTable( {
            data: waiting,
            columns: [
                // {data: "last_name", title: "Last Name", orderData: [0, 1], orderSequence: ["asc"]},
                // {data: "first_name", title: "First Name", orderable: false},
                { data: "ministry.name_shortform", title: "Ministry", orderData: [0], orderSequence: ["asc"]},
                { data: "combined_name", title: "Name", orderable: false},
                { data: "milestone.years", title: "Milestone", orderable: false},
                { data: "ceremony.date", title: "Ceremony Date", orderable: false, render: function( data, type, row, meta) {
                        const months = ["Jan", "Feb", "Mar","Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        var d = new Date(data);
                        var formatted_date = "n/a";

                        if (!isNaN(d.getTime())) {
                            formatted_date = months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
                        }

                        return formatted_date;
                    } },
                // {data: "attend_status", title: "Attending", orderable: false},
                { data: "award_name", title: "Award", orderable: false},


                { data: "guest", title: "Guest", orderable: false, render: function (data, type, row) {
                    if (type === 'display' || type === 'filter' ) {
                        if (data == true) {
                            return "Yes";
                        }
                        if (data == false) {
                            return "No";
                        }
                    }
                    return data;
                } },





            ],
            // stateSave: true,
            pageLength: 12,
            pagingType: 'simple',
            lengthChange: false,
            // order: [[ 1, "asc" ]],

            dom: '<"toolbar">Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export to CSV',
                    filename: function () {
                        return datestr + '-waiting-list';
                    },
                },
                {
                    extend: 'excel',
                    text: 'Export to Excel',
                    filename: function () {
                        return datestr + '-waiting-list';
                    },
                }
            ],


            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },






            initComplete: function () {
            },


        });

        btns = '<div>';
        btns += '<button class="btn btn-primary" onClick="selectFromList()">Add</button>';
        btns += '</div>';

        $("div.toolbar").html(btns);


        $('#data-table-2').DataTable( {
            data: recipients,
            columns: [
                { data: "last_name", title: "Last Name", orderData: [0, 1], orderSequence: ["asc"]},
                { data: "first_name", title: "First Name", orderable: false},
                { data: "id", title: "ID" },
                { data: "id", title: "Wait List", orderable: false, render: function( data, type, row, meta) {
                            button = '<button onclick="addToWaitList(' + data + ')">Add to Wait List</button>';
                        return button;
                    }
                },
                { data: "milestone.years", title: "Milestone", orderable: false},
                { data: "ministry.name_shortform", title: "Ministry", orderData: [0], orderSequence: ["asc"]},
                { data: "award_name", title: "Award", orderable: false},
            ],

            pageLength: 12,
            pagingType: 'simple',
            lengthChange: false,

            dom: '<"toolbar2">Bfrtip',
            buttons: [            ],

            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },

            initComplete: function () {
            },

        });

        btns = '<div>';
        btns += '<button class="btn btn-primary" onClick="selectWaitList()">Return to Waiting List</button>';
        btns += '</div>';

        $("div.toolbar2").html(btns);

    } );


    function selectFromList() {

        $('#table-1').hide();
        $('#table-2').show();
    }

    function selectWaitList() {

        $('#table-1').show();
        $('#table-2').hide();
    }

    function addToWaitList(id) {

        $.ajax({
            url: waiturl,
            headers: {
                'X-CSRF-Token': <?= json_encode($this->request->getAttribute('csrfToken')); ?>
            },
            type:'POST',
            data: { id : id },
            success:function(response){
                idx  = findId(recipients, id);
                waiting.push(recipients[idx]);
                recipients.splice(idx, 1);

                $('#data-table-1').DataTable().clear();
                $('#data-table-1').DataTable().rows.add(waiting);
                $('#data-table-1').DataTable().draw();

                $('#data-table-2').DataTable().clear();
                $('#data-table-2').DataTable().rows.add(recipients);
                $('#data-table-2').DataTable().draw();

                $('#table-2').hide();
                $('#table-1').show();
            }
        });


        function findId(list, id) {
            idx = -1;
            for (var i = 0; i < list.length; i++) {
                if (list[i].id == id) {
                    idx = i;
                }
            }
            return idx;
        }
    }

</script>


