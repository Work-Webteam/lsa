<div class="container" id="app">
    <h1>Edit VIP</h1>
    <?php
    echo $this->Form->create($vip, ['@submit' => 'processForm']);

    echo $this->Form->control('first_name');
    echo $this->Form->control('last_name');

    echo $this->Form->control('prefix');
    echo $this->Form->control('title');
    echo $this->Form->control('address_street', ['label' => 'Street Address']);
    echo $this->Form->control('address_po_box', ['label' => 'PO Box']);
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
                console.log("edit - processForm");
                errors = [];

                if ($('#first-name').val().length == 0) {
                    $('#first-name').css("border-color", clrError);
                    errors.push('First Name is required');
                }
                else {
                    $('#first-name').css("border-color", clrDefault);
                }

                if ($('#last-name').val().length == 0) {
                    $('#last-name').css("border-color", clrError);
                    errors.push('Last Name is required');
                }
                else {
                    $('#last-name').css("border-color", clrDefault);
                }

                if ($('#address-street').val().length == 0) {
                    $('#address-street').css("border-color", clrError);
                    errors.push('Street Address is required');
                }
                else {
                    $('#address-street').css("border-color", clrDefault);
                }

                if ($('#postal-code').val().length == 0) {
                    $('#postal-code').css("border-color", clrError);
                    errors.push('Postal Code is required');
                }
                else {
                    $('#postal-code').css("border-color", clrDefault);
                }

                if ($('#phone').val().length == 0) {
                    $('#phone').css("border-color", clrError);
                    errors.push('Postal Code is required');
                }
                else {
                    $('#phone').css("border-color", clrDefault);
                }

                if ($('#email').val().length == 0) {
                    $('#email').css("border-color", clrError);
                    errors.push('Email is required');
                }
                else {
                    if (!isEmail($('#email').val())) {
                        $('#email').css("border-color", clrError);
                        errors.push('Email invalid format');
                    }
                    else {
                        $('#email').css("border-color", clrDefault);
                    }
                }

                if ($('#contact-first-name').val().length == 0) {
                    $('#contact-first-name').css("border-color", clrError);
                    errors.push('Contact First Name is required');
                }
                else {
                    $('#contact-first-name').css("border-color", clrDefault);
                }

                if ($('#contact-last-name').val().length == 0) {
                    $('#contact-last-name').css("border-color", clrError);
                    errors.push('Contact Last Name is required');
                }
                else {
                    $('#contact-last-name').css("border-color", clrDefault);
                }

                if ($('#contact-phone').val().length == 0) {
                    $('#contact-phone').css("border-color", clrError);
                    errors.push('Contact Phone is required');
                }
                else {
                    $('#contact-phone').css("border-color", clrDefault);
                }

                // checked = false;
                // for (var i = 0; i < milestones.length; i++) {
                //     if ($('#milestone-' + milestones[i].id).prop("checked") ) {
                //         checked = true;
                //     }
                // }
                // if (!checked) {
                //     errors.push('At least one milestone required');
                // }

                //
                // if ($('#name-filter').prop("checked")) {
                //     if ($('#name-start').val().length == 0) {
                //         errors.push('Start letter required');
                //     }
                //     if ($('#name-end').val().length == 0) {
                //         errors.push('End letter required');
                //     }
                // }

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


    function isEmail (email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function isPhone (phone) {
        var regex = /\(([0-9]{3})\) ([0-9]{3})-([0-9]{4})/;
        return regex.test(phone);
    }

    function isPostalCode (code) {
        var regex = /^[ABCEGHJ-NPRSTVXY][0-9][ABCEGHJ-NPRSTV-Z] [0-9][ABCEGHJ-NPRSTV-Z][0-9]$/;
        return regex.test(code);
    }


</script>
