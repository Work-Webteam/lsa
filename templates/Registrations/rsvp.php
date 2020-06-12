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
        echo $this->Form->hidden('accessibility_requirements_recipient');
        echo $this->Form->hidden('accessibility_requirements_guest');
        echo $this->Form->hidden('dietary_requirements_recipient');
        echo $this->Form->hidden('dietary_requirements_guest');
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
        <div><Strong>I require:</Strong></div>

        <?php
            foreach ($accessibility as $item):
                echo '<div>';
                echo '<label for="accessR-' . $item->id . '">';
                echo '<input type="checkbox" id="accessR-' . $item->id . '" value=' . $item->id . ' v-model="accessRecipientSelections">';
                echo '&nbsp;&nbsp;' . $item->name . '</label>';
                echo '</div>';
            endforeach;

            echo $this->Form->control('accessibility_recipient_notes', ['type' => 'textarea', 'rows' => '6', 'cols' => '50']);
        ?>

    </div>

    <div id="guest-accessibility" v-if="recipientAccessibilityGuest">
        <Strong>My guest requires:</Strong>
        <?php
            foreach ($accessibility as $item):
                echo '<div>';
                echo '<label for="accessG-' . $item->id . '">';
                echo '<input type="checkbox" id="accessG-' . $item->id . '" value=' . $item->id . ' v-model="accessGuestSelections">';
                echo '&nbsp;&nbsp;' . $item->name . '</label>';
                echo '</div>';
            endforeach;

            echo $this->Form->control('accessibility_guest_notes', ['type' => 'textarea', 'rows' => '6', 'cols' => '50']);
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
            foreach ($diet as $item):
                echo '<div>';
                echo '<label for="dietR-' . $item->id . '">';
                echo '<input type="checkbox" id="dietR-' . $item->id . '" value=' . $item->id . ' v-model="dietRecipientSelections">';
                echo '&nbsp;&nbsp;' . $item->name . '</label>';
                echo '</div>';
            endforeach;

            echo $this->Form->control('dietary_recipient_other', ['type' => 'textarea', 'rows' => '6', 'cols' => '50']);
        ?>
    </div>

    <div id="guest-dietary" v-if="recipientDietaryGuest">
        <Strong>My guest requires food options that are: [multi-select]</Strong>
        <?php
            foreach ($diet as $item):
                echo '<div>';
                echo '<label for="dietG-' . $item->id . '">';
                echo '<input type="checkbox" id="dietG-' . $item->id . '" value=' . $item->id . ' v-model="dietGuestSelections">';
                echo '&nbsp;&nbsp;' . $item->name . '</label>';
                echo '</div>';
            endforeach;

            echo $this->Form->control('dietary_guest_other', ['type' => 'textarea', 'rows' => '6', 'cols' => '50']);
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

            recipientAttending: <?php echo $registration->attending ? $registration->attending : 0; ?>,
            recipientGuest: <?php echo $registration->guest ? $registration->guest : 0; ?>,
            recipientAccessibilityRecipient: <?php echo $registration->accessibility_recipient ? $registration->accessibility_recipient : 0; ?>,
            recipientAccessibilityGuest: <?php echo $registration->accessibility_guest ? $registration->accessibility_guest : 0; ?>,
            recipientDietaryRecipient: <?php echo $registration->recipient_diet ? $registration->recipient_diet : 0; ?>,
            recipientDietaryGuest: <?php echo $registration->guest_diet ? $registration->guest_diet : 0; ?>,
            currentAttending: null,

            accessibilityRecipient: null,
            accessibilityGuest: null,
            dietRecipient: null,
            dietGuest: null,

            accessRecipientSelections: <?php echo $registration->accessibility_requirements_recipient; ?>,
            accessGuestSelections: <?php echo $registration->accessibility_requirements_guest; ?>,
            dietRecipientSelections: <?php echo $registration->dietary_requirements_recipient; ?>,
            dietGuestSelections: <?php echo $registration->dietary_requirements_guest; ?>,

            errorsOptions: '',

        },

        mounted() {

            if (this.recipientAttending && this.recipientGuest) {
                this.buttonAttendingWith(2);
            }
            else if (this.recipientAttending && !this.recipientGuest) {
                this.buttonAttendingWith(1);
            }
            else {
                this.buttonAttendingWith(0);
            }

            this.setAccessibilityButtons();
            this.setDietaryButtons();
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

                console.log(this.accessRecipientSelections);
                console.log(this.accessGuestSelections);
                console.log(this.dietRecipientSelections);
                console.log(this.dietGuestSelections);

                $('input[name=accessibility_requirements_recipient]').val(JSON.stringify(this.accessRecipientSelections));
                $('input[name=accessibility_requirements_guest]').val(JSON.stringify(this.accessGuestSelections));
                $('input[name=dietary_requirements_recipient]').val(JSON.stringify(this.dietRecipientSelections));
                $('input[name=dietary_requirements_guest]').val(JSON.stringify(this.dietGuestSelections));

                console.log(this.recipientAttending);
                console.log(this.recipientGuest);

                console.log(this.recipientAccessibilityRecipient);
                console.log(this.recipientAccessibilityGuest);

                console.log(this.recipientDietaryRecipient);
                console.log(this.recipientDietaryGuest);
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
            },

            buttonAccessibility: function (id) {

                if (id == 2) {
                    this.recipientAccessibilityRecipient = !this.recipientAccessibilityRecipient;
                }
                else if (id == 1) {
                    this.recipientAccessibilityGuest = !this.recipientAccessibilityGuest;
                }
                else {
                    this.recipientAccessibilityRecipient = false;
                    this.recipientAccessibilityGuest = false;
                }
                this.setAccessibilityButtons();
            },

            setAccessibilityButtons() {
                if (this.recipientAccessibilityRecipient) {
                    $("#btn-access-2").removeClass('btn-secondary').addClass('btn-primary');
                    $("#btn-access-0").removeClass('btn-primary').addClass('btn-secondary');
                }
                else {
                    $("#btn-access-2").removeClass('btn-primary').addClass('btn-secondary');
                }
                if (this.recipientAccessibilityGuest) {
                    $("#btn-access-1").removeClass('btn-secondary').addClass('btn-primary');
                    $("#btn-access-0").removeClass('btn-primary').addClass('btn-secondary');
                }
                else {
                    $("#btn-access-1").removeClass('btn-primary').addClass('btn-secondary');
                }
                if (!this.recipientAccessibilityRecipient && !this.recipientAccessibilityGuest) {
                    $("#btn-access-2").removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-access-1").removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-access-0").removeClass('btn-secondary').addClass('btn-primary');
                }
            },


            buttonDietary: function (id) {

                if (id == 2) {
                    this.recipientDietaryRecipient = !this.recipientDietaryRecipient;
                }
                else if (id == 1) {
                    this.recipientDietaryGuest = !this.recipientDietaryGuest;
                }
                else {
                    this.recipientDietaryRecipient = false;
                    this.recipientDietaryGuest = false;
                }
                this.setDietaryButtons();
            },

            setDietaryButtons() {
                if (this.recipientDietaryRecipient) {
                    $("#btn-dietary-2").removeClass('btn-secondary').addClass('btn-primary');
                    $("#btn-dietary-0").removeClass('btn-primary').addClass('btn-secondary');
                }
                else {
                    $("#btn-dietary-2").removeClass('btn-primary').addClass('btn-secondary');
                }
                if (this.recipientDietaryGuest) {
                    $("#btn-dietary-1").removeClass('btn-secondary').addClass('btn-primary');
                    $("#btn-dietary-0").removeClass('btn-primary').addClass('btn-secondary');
                }
                else {
                    $("#btn-dietary-1").removeClass('btn-primary').addClass('btn-secondary');
                }
                if (!this.recipientDietaryRecipient && !this.recipientDietaryGuest) {
                    $("#btn-dietary-2").removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-dietary-1").removeClass('btn-primary').addClass('btn-secondary');
                    $("#btn-dietary-0").removeClass('btn-secondary').addClass('btn-primary');
                }
            }

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
