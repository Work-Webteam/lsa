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
    echo $this->Form->control('mobile');
    echo $this->Form->control('fax');
    echo $this->Form->control('email');

    echo $this->Form->control('contact_first_name');
    echo $this->Form->control('contact_last_name');
    echo $this->Form->control('contact_prefix');
    echo $this->Form->control('contact_title');
    echo $this->Form->control('contact_phone');
    echo $this->Form->control('contact_fax');

    echo $this->Form->control('ministry_id', ['label' => 'Ministry', 'options' => $ministries, 'empty' => '- select ministry -']);
    echo $this->Form->control('ceremony_id', ['label' => 'Ceremony', 'options' => $ceremonies, 'empty' => '- select ceremony -']);
    echo $this->Form->control('group');
    echo $this->Form->control('category_id', ['label' => 'Category', 'options' => $categories, 'empty' => '- select category -']);

    echo $this->Form->control('attending', ['label' => 'Attending', 'options' => $attending]);
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
                    if (!isPostalCode($('#postal-code').val())) {
                        $('#email').css("border-color", clrError);
                        errors.push('Postal Code invalid format');
                    }
                    else {
                        $('#postal-code').css("border-color", clrDefault);
                    }
                }

                if ($('#phone').val().length == 0) {
                    $('#phone').css("border-color", clrError);
                    errors.push('Phone is required');
                }
                else {
                    if (!isPhone($('#phone').val())) {
                        $('#phone').css("border-color", clrError);
                        errors.push('Phone invalid format');
                    }
                    else {
                        $('#phone').css("border-color", clrDefault);
                    }
                }

                if ($('#mobile').val().length > 0) {
                      if (!isPhone($('#mobile').val())) {
                        $('#mobile').css("border-color", clrError);
                        errors.push('Mobile invalid format');
                    }
                    else {
                        $('#mobile').css("border-color", clrDefault);
                    }
                }
                else {
                    $('#mobile').css("border-color", clrDefault);
                }
                
                if ($('#fax').val().length > 0) {
                    if (!isPhone($('#fax').val())) {
                        $('#fax').css("border-color", clrError);
                        errors.push('Fax invalid format');
                    }
                    else {
                        $('#fax').css("border-color", clrDefault);
                    }
                }
                else {
                    $('#fax').css("border-color", clrDefault);
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
                    if (!isPhone($('#contact-phone').val())) {
                        $('#contact-phone').css("border-color", clrError);
                        errors.push('Contact Phone invalid format');
                    }
                    else {
                        $('#contact-phone').css("border-color", clrDefault);
                    }
                }

                if ($('#contact-fax').val().length > 0) {
                    if (!isPhone($('#contact-fax').val())) {
                        $('#contact-fax').css("border-color", clrError);
                        errors.push('Contact Fax invalid format');
                    } else {
                        $('#contact-fax').css("border-color", clrDefault);
                    }
                }
                else {
                    $('#contact-fax').css("border-color", clrDefault);
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
