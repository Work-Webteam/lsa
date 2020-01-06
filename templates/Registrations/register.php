<div class="container" id="app">
<h1>Register for Long Service Award</h1>
<?php
echo $this->Form->create($registration);

echo $this->Form->label("Retiring this year?");
//echo $this->Form->radio('retiring_this_year', [['value' => 1, 'text' => 'Yes'], ['value' => 0, 'text' => 'No']]);
echo $this->Form->hidden('retiring_this_year', ['value' => 2]);
echo $this->Form->hidden('award_instructions', ['value' => 'some text']);
?>

    <div class="form-group">
        <label for="isRetiringThisYear">Are you retiring in <?php echo date("Y") ?>?</label>
        <div aria-label="retiring selection" class="btn-group" role="group">
            <button class="btn btn-secondary" type="button" v-on:click="exposeRetirementDatePicker">Yes</button>
            <button class="btn btn-secondary" type="button" v-on:click="setRetirementStatusKnown">No</button>
        </div>
    </div>

    <transition name="fade">
        <div class="form-group" id="retirementdate" v-if="isRetiringThisYear">
<?php
    echo $this->Form->control('date', ['label' => 'Retirement Date', 'type' => 'date', 'value' => date('Y-m-d'), 'minYear' => date('Y'), 'maxYear' => date('Y')]);
?>
        </div>
    </transition>

    <transition name="fade">
        <div class="form-group" v-if="retirementStatusKnown">
    <?php


echo $this->Form->control('milestone_id', ['options' => $milestones]);


echo $this->Form->control('award_id', ['options' => $awards]);

?>
        </div>
    </transition>

<a class="btn btn-primary" href="#" v-on:click="showIdentifyingInfoInputs">Selected Award</a>

<transition name="fade">
    <fieldset id="identifyingInfo" v-show="awardSelected">
<?php

echo $this->Form->control('employee_id', ['label' => 'Employee ID', 'type' => 'text']);
echo $this->Form->control('first_name');
echo $this->Form->control('last_name');

echo $this->Form->control('ministry_id', ['options' => $ministries]);
echo $this->Form->control('department');

?>
        <a class="btn btn-primary" href="#officeAddressAnchor" v-on:click="showOfficeAddressInput">ID Info Input</a>
    </fieldset>
</transition>

<transition name="fade">

   <fieldset id="officeAddress" v-show="identifyingInfoInput">
<?php

echo $this->Form->control('office_address');
echo $this->Form->control('office_city_id', ['options' => $cities]);
echo $this->Form->control('office_province', ['disabled' => true]);
echo $this->Form->control('office_postal_code');
?>
       <a class="btn btn-primary" href="#homeAddressAnchor" v-on:click="showHomeAddressInput">Office Address Input</a><a id="officeAddressAnchor"></a>
   </fieldset>
</transition>

<transition name="fade">
   <fieldset id="homeAddress" v-show="officeAddressInput">

<?php
echo $this->Form->control('home_address');
echo $this->Form->control('home_city_id', ['options' => $cities]);
echo $this->Form->control('home_province', ['disabled' => true]);
echo $this->Form->control('home_postal_code');
echo $this->Form->control('home_phone');
?>
       <a class="btn btn-primary" href="#supervisorAnchor" v-on:click="showSupervisorInput">Home Address Input</a><a id="homeAddressAnchor"></a>
   </fieldset>
</transition>

<transition name="fade">
   <fieldset id="supervisor" v-if="homeAddressInput">

<?php
echo $this->Form->control('supervisor_first_name');
echo $this->Form->control('supervisor_last_name');
echo $this->Form->control('supervisor_address');
echo $this->Form->control('supervisor_city_id', ['options' => $cities]);
echo $this->Form->control('supervisor_province', ['disabled' => true]);
echo $this->Form->control('supervisor_postal_code');
echo $this->Form->control('supervisor_email', ['type' => 'email']);
?>
       <a class="btn btn-primary" href="#confirmInfo" v-on:click="showConfirmation">Supervisor Input</a>
   </fieldset>
</transition>

<transition name="fade">
   <div class="confirmationDisplay" v-if="supervisorInput">

      some stuff here

   </div>
</transition>
    <div>
<?php
echo $this->Form->button(__('Register'));
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\''
));
echo $this->Form->end();
?>
    </div>
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
    $(function () {
        $('#datetimepicker1').datetimepicker({format: 'L'});
    });

    Vue.config.devtools = true

    var app = new Vue({
        el: "#app",
        data: {
            isRetiringThisYear: false,
            retirementStatusKnown: false,
            retirementDate: '',
            yearsOfService: 0,

            employeeID: '',
            firstName: '',
            lastName: '',
            ministry: '',
            branch: '',
            officeMailPrefix: '',
            officeSuite: '',
            officeStreetAddress: '',
            officeCity: '',
            officePostalCode: '',
            homeSuite: '',
            homeStreetAddress: '',
            homeCity: '',
            homePostalCode: '',
            supervisorFirstName: '',
            supervisorLastName: '',
            supervisorMailPrefix: '',
            supervisorSuite: '',
            supervisorStreetAddress: '',
            supervisorCity: '',
            supervisorPostalCode: '',
            awardSelected: false,
            identifyingInfoInput: false,
            officeAddressInput: false,
            homeAddressInput: false,
            supervisorInput: false,
            informationConfirmed: false
        },
        methods: {
            exposeRetirementDatePicker: function () {
                console.log("here");
                console.log($('retiring_this_year'));
                $('#retiring_this_year').val(1);
                this.isRetiringThisYear = true;
                this.retirementStatusKnown = true;
            },
            setRetirementStatusKnown: function () {
                $('#retiring_this_year').val(0);
                this.isRetiringThisYear = false;
                this.retirementStatusKnown = true;
            },
            showIdentifyingInfoInputs: function () {
                // $('#Registrationsaward_instructions').value = "stuff";
                $("award_instructions").val("test");
                this.awardSelected = true;

            },
            showOfficeAddressInput: function () {
                this.identifyingInfoInput = true;

            },
            showHomeAddressInput: function () {
                this.officeAddressInput = true;

            },
            showSupervisorInput: function () {
                this.homeAddressInput = true;

            },
            showConfirmation: function () {
                this.supervisorInput = true;

            },
            showDeclaration: function () {
                this.informationConfirmed = true;

            }


        }
    })
    var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 1500
    });


    /* TODO :
- Configure the retirement buttons as a toggle with visible state
- Have inputs hide UI elements as appropriate
- Form Validation:
- Employee ID
- Postal Code
- Autocomplete:
- Ministry
- Branch
- City
- Load awards info and populate cards
- Disable "register" button until checkbox is ticked.
- Datepicker needs to be fixed
- Tab Index needs to be tested/fixed
- Progress Indicator should be included
- Handle submission AJAX
*/
</script>
