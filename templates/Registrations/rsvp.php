<div class="container" id="app">

    <h1><?= $registration->first_name . " " . $registration->last_name ?></h1>

    <?php
    echo $this->Form->create($registration, ['@submit' => 'processForm', 'horizontal' => true]);

    echo $this->Form->hidden('attending', ['v-model' => 'recipientAttending']);
    echo $this->Form->hidden('guest', ['v-model' => 'recipientGuest']);
    echo $this->Form->hidden('accessibility_recipient', ['v-model' => 'recipientAccessibilityRecipient']);
    echo $this->Form->hidden('accessibility_guest', ['v-model' => 'recipientAccessibilityGuest']);
    echo $this->Form->hidden('recipient_diet', ['v-model' => 'recipientDietaryRecipient']);
    echo $this->Form->hidden('guest_diet', ['v-model' => 'recipientDietaryGuest']);

    ?>


    <center>
        <h1>RSVP</h1>
        <h4>For the <?= $registration->award_year ?> Long Service Awards</h4>
        <h4><?= date("F j", strtotime($ceremony->date)) . " at " . date("g:ia", strtotime($ceremony->date)) ?></h4>
        <h4>at Government House</h4>
        <h4>1401 Rockland Ave, Victoria</h4>
        <h2>Kindly respond by [DATE]</h2>
    </center>

    <?php

    echo $this->Form->button('Will attend with guest', ['type' => 'button', 'id' => 'btn-attend-2', 'onclick' => 'app.buttonAttendingWith(2)', 'class' => 'btn btn-secondary']);
    echo "&nbsp;";
    echo $this->Form->button('Will attend without guest', ['type' => 'button', 'id' => 'btn-attend-1',  'onclick' => 'app.buttonAttendingWith(1)', 'class' => 'btn btn-secondary']);
    echo "&nbsp;";
    echo $this->Form->button("Won't attend", ['type' => 'button', 'id' => 'btn-attend-0',  'onclick' => 'app.buttonAttendingWith(0)', 'class' => 'btn btn-secondary']);

    ?>

    <div>
        <h3>Inclusivity</h3>
        <p>
            The Long Service awards ceremonies are welcoming and accessbile events.
        </p>
        <br>
        <p>Government House has gender-neutral washroom facitilites.</p>
        <p>Check the Venue Accessibility[LINK] page for specific locations or contact [EMAIL] with questions</p>
    </div>

    <div>
        <h3>Accessibility Requirements</h3>
        <p>To ensure you and your guest can enjoy the festivities, please share you accessibility requirements with us.</p>
        <BR>
        <p>If you'd like a preview of accessible facilities at Government House including ramps, elevators and washroom facilities, vist the
        Venue Accessibility[LINK] page. If you have quetions or wish to connect wiht a member of the Long Service Awards team directly, contact [EMAIL].</p>
    </div>

    <?php

    echo $this->Form->button('I have accessibility requirements', ['type' => 'button', 'id' => 'btn-access-2', 'onclick' => 'app.buttonAccessibility(2)', 'class' => 'btn btn-secondary']);
    echo "&nbsp;";
    echo $this->Form->button('My guest has accessibility requirements', ['type' => 'button', 'id' => 'btn-access-1',  'onclick' => 'app.buttonAccessibility(1)', 'class' => 'btn btn-secondary']);
    echo "&nbsp;";
    echo $this->Form->button("No accessibility requirements in my party", ['type' => 'button', 'id' => 'btn-access-0',  'onclick' => 'app.buttonAccessibility(0)', 'class' => 'btn btn-primary']);

    ?>

    <div id="recipient-accessibility" v-if="recipientAccessibilityRecipient">
        <Strong>I require:</Strong>
<!--        --><?php
////            echo $this->Form->select('accessibilityRecipient', $accessibility, ['multiple' => true]);
////        echo $this->Form->checkbox($accessibility, ['hiddenField' => false]);
//        ?>
<!--        --><?php //foreach ($accessibility as $item): ?>
<!---->
<!--        --><?php
////            debug($item);
//            echo $this->Form->checkbox($item, ['label' => 'test.1', 'name' => $item, 'hiddenField' => false]);
//
//            ?>
<!---->
<!--        --><?php //endforeach; ?>
        <?php
        echo $this->Form->select('accessibilityGuest', $accessibility, []);
        ?>

    </div>

    <div id="guest-accessibility" v-if="recipientAccessibilityGuest">
        <Strong>My guest requires:</Strong>
        <?php
            echo $this->Form->select('accessibilityGuest', $accessibility, []);
        ?>
    </div>

    <div>
        <h3>Dietary Requirements</h3>
        <p>
            To ensure we have menu options that will accommodate your dietary restrictions and allergies, please indicate your requirements.
        </p>
    </div>

    <?php

    echo $this->Form->button('I have dietary requirements', ['type' => 'button', 'id' => 'btn-dietary-2', 'onclick' => 'app.buttonDietary(2)', 'class' => 'btn btn-secondary']);
    echo "&nbsp;";
    echo $this->Form->button('My guest has dietary requirements', ['type' => 'button', 'id' => 'btn-dietary-1',  'onclick' => 'app.buttonDietary(1)', 'class' => 'btn btn-secondary']);
    echo "&nbsp;";
    echo $this->Form->button("No dietary requirements in my party", ['type' => 'button', 'id' => 'btn-dietary-0',  'onclick' => 'app.buttonDietary(0)', 'class' => 'btn btn-primary']);

    ?>

    <div id="guest-dietary" v-if="recipientDietaryRecipient">
        <Strong>I require food options that are: [multi-select]:</Strong>
        <?php
        echo $this->Form->select('accessibilityGuest', $diet, []);
        ?>
    </div>

    <div id="guest-dietary" v-if="recipientDietaryGuest">
        <Strong>My guest requires food options that are: [multi-select]</Strong>
        <?php
        echo $this->Form->select('accessibilityGuest', $diet, []);
        ?>
    </div>


    <div id="lsa-edit-errors">
        <span v-html="errorsOptions" class="lsa-errors-container">
        </span>
    </div>
    <?php
    echo $this->Form->button(__('Save RSVP'), [
        'class' => 'btn btn-primary'
    ]);
    echo '&nbsp;';
    echo $this->Form->button('Cancel', array(
        'type' => 'button',
        'onclick' => 'location.href=\'/\'',
        'class' => 'btn btn-secondary'
    ));
    echo $this->Form->end();
    ?>



</div>



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


    var app = new Vue({
        el: '#app',

        data: {

            recipientAttending: null,
            recipientGuest: null,
            recipientAccessibilityRecipient: false,
            recipientAccessibilityGuest: false,
            recipientDietaryRecipient: false,
            recipientDietaryGuest: false,
            currentAttending: null,

            errorsOptions: '',

        },



        methods: {

            processForm: function(e) {
                console.log('processForm');

                if (this.currentAttending == 2) {
                    this.recipientAttending = true;
                    this.recipientGuest = true;
                }
                else if (this.currentAttending == 1) {
                    this.recipientAttending = true;
                    this.recipientGuest = false;
                }
                else {
                    this.recipientAttending = false;
                    this.recipientGuest = false;
                }
                console.log(this.recipientAttending);
                console.log(this.recipientGuest);

                console.log(this.recipientAccessibilityRecipient);
                console.log(this.recipientAccessibilityGuest);

            },

            buttonAttendingWith: function (id) {

                console.log("buttonAttendingWith: " + id);

                if (this.currentAttending != id) {
                    if (this.currentAttending !== null) {
                        $("#btn-attend-" + this.currentAttending).removeClass('btn-primary').addClass('btn-secondary');
                    }
                    $("#btn-attend-" + id).removeClass('btn-secondary').addClass('btn-primary');
                    this.currentAttending = id;
                }
                // console.log(id);
            },

            buttonAccessibility: function (id) {

                // console.log("buttonAccessibility: " + id);

                if (id == 2) {
                    this.recipientAccessibilityRecipient = !this.recipientAccessibilityRecipient;
                    if (this.recipientAccessibilityRecipient) {
                        $("#btn-access-" + id).removeClass('btn-secondary').addClass('btn-primary');
                        $("#btn-access-" + 0).removeClass('btn-primary').addClass('btn-secondary');
                    }
                    else {
                        $("#btn-access-" + id).removeClass('btn-primary').addClass('btn-secondary');
                    }
                }
                else if (id == 1) {
                    this.recipientAccessibilityGuest = !this.recipientAccessibilityGuest;
                    if (this.recipientAccessibilityGuest) {
                        $("#btn-access-" + id).removeClass('btn-secondary').addClass('btn-primary');
                        $("#btn-access-" + 0).removeClass('btn-primary').addClass('btn-secondary');
                    }
                    else {
                        $("#btn-access-" + id).removeClass('btn-primary').addClass('btn-secondary');
                    }
                }
                else {
                    this.recipientAccessibilityRecipient = false;
                    this.recipientAccessibilityGuest = false;
                    $("#btn-access-" + 1).removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-access-" + 2).removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-access-" + 0).removeClass('btn-secondary').addClass('btn-primary');
                }

                // console.log(id);
            },

            buttonDietary: function (id) {

                // console.log("buttonDietary: " + id);

                if (id == 2) {
                    this.recipientDietaryRecipient = !this.recipientDietaryRecipient;
                    if (this.recipientDietaryRecipient) {
                        $("#btn-dietary-" + id).removeClass('btn-secondary').addClass('btn-primary');
                        $("#btn-dietary-0").removeClass('btn-primary').addClass('btn-secondary');
                    }
                    else {
                        $("#btn-dietary-" + id).removeClass('btn-primary').addClass('btn-secondary');
                        if (!this.recipientDietaryRecipient && !this.recipientDietaryGuest) {
                            $("#btn-dietary-0").removeClass('btn-secondary').addClass('btn-primary');
                        }
                    }
                }
                else if (id == 1) {
                    this.recipientDietaryGuest = !this.recipientDietaryGuest;
                    if (this.recipientDietaryGuest) {
                        $("#btn-dietary-" + id).removeClass('btn-secondary').addClass('btn-primary');
                        $("#btn-dietary-0").removeClass('btn-primary').addClass('btn-secondary');
                    }
                    else {
                        $("#btn-dietary-" + id).removeClass('btn-primary').addClass('btn-secondary');
                        if (!this.recipientDietaryRecipient && !this.recipientDietaryGuest) {
                            $("#btn-dietary-0").removeClass('btn-secondary').addClass('btn-primary');
                        }
                    }
                }
                else {
                    this.recipientDietaryRecipient = false;
                    this.recipientDietaryGuest = false;
                    $("#btn-dietary-" + 1).removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-dietary-" + 2).removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-dietary-" + 0).removeClass('btn-secondary').addClass('btn-primary');
                }

                // console.log(id);
            },

    }

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

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
    }

</script>
