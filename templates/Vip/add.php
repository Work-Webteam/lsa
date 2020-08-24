<div class="container" id="app">
<h1>Add VIP</h1>
<?php
echo $this->Form->create($vip, ['@submit' => 'processForm']);

echo $this->Form->control('first_name');
echo $this->Form->control('last_name');

echo $this->Form->control('prefix');
echo $this->Form->control('title');
echo $this->Form->control('address_street');
echo $this->Form->control('address_po_box');
echo $this->Form->control('city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
echo $this->Form->control('postal_code');

echo $this->Form->control('phone');
echo $this->Form->control('mobile_phone');
echo $this->Form->control('fax_phone');
echo $this->Form->control('email');

echo $this->Form->control('contact_first_name');
echo $this->Form->control('contact_last_name');
echo $this->Form->control('contact_prefix');
echo $this->Form->control('contact_title');
echo $this->Form->control('contact_phone');
echo $this->Form->control('contact_fax');

echo $this->Form->control('attending');
echo $this->Form->control('attending_designate');
echo $this->Form->control('invitation_sent');
echo $this->Form->control('total_attending');
echo $this->Form->control('parking_required');
echo $this->Form->control('parking_sports_required');

echo $this->Form->control('guest_first_name');
echo $this->Form->control('guest_last_name');
echo $this->Form->control('guest_prefix');
echo $this->Form->control('guest_title');

echo $this->Form->control('notes');

?>
                <div id="pop-up-errors">
                        <span v-html="msgErrors" class="lsa-errors-container">
                        </span>
                </div>

<?php

echo $this->Form->button(__('Save VIP'), ['class' => 'btn btn-primary']);
echo '&nbsp;';
echo $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/vip\'',
    'class' => 'btn btn-secondary'
]);
echo $this->Form->end();
?>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>


<script type="text/javascript">

    var clrError = "#ff0000";
    var clrDefault = "#d1d1d1";
    var cities = <?php echo json_encode($cities); ?>;

    var app = new Vue({
        el: '#app',

        data: {
            ceremony: '',
            milestone: '',
            city: '',
            msgErrors: '',
            nameFilter: false,
        },

        mounted() {
            console.log("mounted()");
        },


        methods: {

            processForm: function (e) {
                console.log("add - processForm");
                errors = [];

                if ($('#ministry-id').val().length == 0) {
                    $('#ministry-id').css("border-color", clrError);
                    errors.push('Ministry is required');
                }
                else {
                    $('#ministry-id').css("border-color", clrDefault);
                }

                checked = false;
                for (var i = 0; i < milestones.length; i++) {
                    if ($('#milestone-' + milestones[i].id).prop("checked") ) {
                        checked = true;
                    }
                }
                if (!checked) {
                    errors.push('At least one milestone required');
                }


                if ($('#name-filter').prop("checked")) {
                    if ($('#name-start').val().length == 0) {
                        errors.push('Start letter required');
                    }
                    if ($('#name-end').val().length == 0) {
                        errors.push('End letter required');
                    }
                }

                if (errors.length > 0) {
                    this.msgErrors = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.msgErrors += '<li>' + errors[i] + '</li>';
                    }
                    this.msgErrors += '</ul>';
                    e.preventDefault();
                } else {
                    // this.msgErrors = 'everything is cool';
                }

            },


            citySelected: function (id) {
                console.log("citySelected");
                console.log(id);

            },


        },

    });

</script>
