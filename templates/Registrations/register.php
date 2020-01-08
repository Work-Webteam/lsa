<div class="container" id="app">
<h1>Register for Long Service Award</h1>
<?php
echo $this->Form->create($registration);

echo $this->Form->label("Retiring this year?");
echo $this->Form->hidden('retiring_this_year', ['value' => 0]);
echo $this->Form->button('Yes', ['type' => 'button', 'onclick' => 'buttonRetirementClick(1)']);
echo $this->Form->button('No', ['type' => 'button', 'onclick' => 'buttonRetirementClick(0)']);

?>

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


    echo $this->Form->control('milestone_id', ['type' => 'select', 'label' => 'Milestone', 'options' => $milestones, 'value' => -1, 'onChange' => 'milestoneSelected(this.value)']);
?>
        </div>
    </transition>

    <transition name="fade">
        <div class="form-group" v-if="milestoneKnown">

<?php

echo $this->Form->control('award_id', ['options' => $awards]);

?>
            <a class="btn btn-primary" href="#" v-on:click="showIdentifyingInfoInputs">Selected Award</a>
        </div>
    </transition>



<transition name="fade">
    <fieldset id="identifyingInfo" v-show="awardSelected">
<?php

echo $this->Form->control('employee_id', ['label' => 'Employee ID', 'type' => 'text', 'v-model' => 'employeeID']);
echo $this->Form->control('first_name', ['v-model' => 'firstName']);
echo $this->Form->control('last_name', ['v-model' => 'lastName']);

echo $this->Form->control('ministry_id', ['options' => $ministries, 'v-model' => 'ministry']);
echo $this->Form->control('department', ['v-model' => 'branch']);

?>
        <a class="btn btn-primary" href="#officeAddressAnchor" v-on:click="showOfficeAddressInput">ID Info Input</a>
    </fieldset>
</transition>

<transition name="fade">

   <fieldset id="officeAddress" v-show="identifyingInfoInput">
<?php

echo $this->Form->control('office_address', ['v-model' => 'officeStreetAddress']);
echo $this->Form->control('office_city_id', ['options' => $cities, 'v-model' => 'officeCity']);
echo $this->Form->control('office_province', ['disabled' => true]);
echo $this->Form->control('office_postal_code', ['v-model' => 'officePostalCode']);
?>
       <a class="btn btn-primary" href="#homeAddressAnchor" v-on:click="showHomeAddressInput">Office Address Input</a><a id="officeAddressAnchor"></a>
   </fieldset>
</transition>

<transition name="fade">
   <fieldset id="homeAddress" v-show="officeAddressInput">

<?php
echo $this->Form->control('home_address', ['v-model' => 'homeStreetAddress']);
echo $this->Form->control('home_city_id', ['options' => $cities, 'v-model' => 'homeCity']);
echo $this->Form->control('home_province', ['disabled' => true]);
echo $this->Form->control('home_postal_code', ['v-model' => 'homePostalCode']);
echo $this->Form->control('home_phone', ['v-model' => 'homePhone']);
?>
       <a class="btn btn-primary" href="#supervisorAnchor" v-on:click="showSupervisorInput">Home Address Input</a><a id="homeAddressAnchor"></a>
   </fieldset>
</transition>

<transition name="fade">
   <fieldset id="supervisor" v-if="homeAddressInput">

<?php

echo $this->Form->control('supervisor_first_name', ['v-model' => 'supervisorFirstName']);
echo $this->Form->control('supervisor_last_name', ['v-model' => 'supervisorLastName']);
echo $this->Form->control('supervisor_address', ['v-model' => 'supervisorStreetAddress']);
echo $this->Form->control('supervisor_city_id', ['options' => $cities, 'v-model' => 'supervisorCity']);
echo $this->Form->control('supervisor_province', ['disabled' => true]);
echo $this->Form->control('supervisor_postal_code', ['v-model' => 'supervisorPostalCode']);
echo $this->Form->control('supervisor_email', ['type' => 'email', 'v-model' => 'supervisorEmail']);

?>
       <a class="btn btn-primary" href="#confirmInfo" v-on:click="showConfirmation">Supervisor Input</a>
   </fieldset>
</transition>

<transition name="fade">
   <div class="confirmationDisplay" v-if="supervisorInput">

       <h3 class="display-4">Please Confirm Your Information</h3>

       <h4>{{firstName}}
           {{lastName}}</h4>

       <p>Employee ID:
           {{employeeID}}</p>
       <div class="row">
           <div class="col-sm-6">
               <h5>Office Address</h5>
               <div class="address">
                   <p>{{officeMailPrefix}}</p>
                   <p>{{officeSuite}}
                       {{officeStreetAddress}}</p>
                   <p>{{officeCity}}, BC</p>
                   <p>{{officePostalCode}}</p>
               </div>
           </div>
           <div class="col-sm-6">
               <h5>Home Address</h5>
               <div class="address">
                   <p>{{homeSuite}}
                       {{homeStreetAddress}}</p>
                   <p>{{homeCity}}, BC</p>
                   <p>{{homePostalCode}}</p>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-sm-6">
               <div class="award">
                   <div class="card award-card">
                       <img alt="..." class="card-img-top" src="http://placekitten.com/400/400">
                       <div class="card-body">
                           <h5 class="card-title">Award Name</h5>
                           <p class="card-text">Here's some quick body text to describe the award.</p>
                           <p class="card-text">Award Option The First, X Option</p>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-sm-6">
               <p class="divisionMinistryDisplay">You work in
                   {{branch}}
                   at
                   {{ministry}}</p>
               <p class="retirementDisplay">You are retiring on
                   {{retirementDate}}</p>

               <h5>Your Supervisor</h5>
               <p>{{supervisorFirstName}}
                   {{supervisorLastName}}</p>
               <div class="address">
                   <p>{{supervisorMailPrefix}}</p>
                   <p>{{supervisorSuite}}
                       {{supervisorStreetAddress}}</p>
                   <p>{{supervisorCity}}, BC</p>
                   <p>{{supervisorPostalCode}}</p>
               </div>
               <a class="btn btn-primary" href="#register" id="confirmInfo" v-on:click="showDeclaration">Confirm</a>
           </div>
       <?php
       echo $this->Form->button(__('Register'));
       echo $this->Form->button('Cancel', array(
           'type' => 'button',
           'onclick' => 'location.href=\'/registrations\''
       ));
       ?>
   </div>
</transition>
    <div>
<?php

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

    function retiringChange(retiring) {
        if (retiring == 1) {
            app.exposeRetirementDatePicker();
        }
        else {
            app.setRetirementStatusKnown();
        }
    };

    function buttonRetirementClick(retiring) {
        $('input[name=retiring_this_year]').val(retiring);
        if (retiring == 1) {
            app.exposeRetirementDatePicker();
        }
        else {
            app.setRetirementStatusKnown();
        }
    }

    function milestoneSelected(milestone) {
        app.exposeAwardSelector(milestone);
    }


    Vue.config.devtools = true

    var app = new Vue({
        el: "#app",
        data: {
            isRetiringThisYear: false,
            retirementStatusKnown: false,
            retirementDate: '',
            yearsOfService: 0,
            milestoneKnown: false,
            milestone: 0,

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
            homePhone: '',
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
                this.isRetiringThisYear = true;
                this.retirementStatusKnown = true;
            },
            setRetirementStatusKnown: function () {
                this.isRetiringThisYear = false;
                this.retirementStatusKnown = true;
            },
            exposeAwardSelector: function(milestone) {
                console.log("exposeAwardSelector");
                console.log(milestone);
                this.milestoneKnown = true;
                this.milestone = milestone;
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
