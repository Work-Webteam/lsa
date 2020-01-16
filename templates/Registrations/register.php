<div class="container" id="app">
<h1>Register for Long Service Award</h1>



<?php



echo $this->Form->create($registration);
?>

    <transition name="fade">
        <div class="form-group">
    <?php


    echo $this->Form->control('milestone_id', ['type' => 'select', 'label' => 'Milestone', 'options' => $milestones, 'empty' => '- select milestone -', 'onChange' => 'app.milestoneSelected(this.value)']);
    echo $this->Form->hidden('award_id', ['value' => 0]);
?>
        </div>
    </transition>

    <transition name="fade">
        <div class="form-group" v-if="milestoneKnown">
            <?php
            echo $this->Form->label("Registered last year but didn't attend ceremony?");
            echo $this->Form->button('Yes', ['type' => 'button', 'onclick' => 'app.buttonMissedCeremony(1)']);
            echo $this->Form->button('No', ['type' => 'button',  'onclick' => 'app.buttonMissedCeremony(0)']);
            ?>
        </div>
    </transition>

    <transition name="fade">
        <div class="form-group" v-if="selectAward">
            <span v-html="availableAwards" class="lsa-awards-container">
            </span>

            <a class="btn btn-primary" href="#identifyingInfo" v-on:click="showIdentifyingInfoInputs">Selected Award</a>
        </div>
    </transition>



<transition name="fade">
    <fieldset id="identifyingInfo" v-show="awardSelected">
<?php

echo $this->Form->control('employee_id', ['label' => 'Employee ID', 'type' => 'text', 'v-model' => 'employeeID']);
echo $this->Form->control('first_name', ['v-model' => 'firstName']);
echo $this->Form->control('last_name', ['v-model' => 'lastName']);

echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => '- select ministry -', 'onChange' => 'app.ministrySelected()']);
echo $this->Form->control('department', ['v-model' => 'branch']);

echo $this->Form->control('preferred_email', ['label' => 'Government Email', 'v-model' => 'govtEmail']);
echo $this->Form->control('alternate_email', ['v-model' => 'altEmail']);

echo $this->Form->label("Retiring this year?");
echo $this->Form->hidden('retiring_this_year', ['value' => 0]);
echo $this->Form->button('Yes', ['type' => 'button', 'onclick' => 'app.buttonRetirementClick(1)']);
echo $this->Form->button('No', ['type' => 'button',  'onclick' => 'app.buttonRetirementClick(0)']);

?>

        <transition name="fade">
            <div class="form-group" id="retirementdate" v-if="isRetiringThisYear">
                <?php
                echo $this->Form->control('date', ['label' => 'Retirement Date', 'type' => 'date', 'value' => date('Y-m-d'), 'minYear' => date('Y'), 'maxYear' => date('Y'), 'v-model' => 'retirementDate']);
                ?>
            </div>
        </transition>


    </fieldset>
</transition>

    <transition name="fade">
        <div v-if="retirementStatusKnown">
            <a class="btn btn-primary" href="#officeAddressAnchor" v-on:click="showOfficeAddressInput">ID Info Input</a>
        </div>
    </transition>


<transition name="fade">

   <fieldset id="officeAddress" v-show="identifyingInfoInput">
<?php

    echo $this->Form->control('office_careof', ['label' => 'Floor / Room / Care Of', 'v-model' => 'officeMailPrefix']);
    echo $this->Form->control('office_suite', ['label' => 'Suite', 'v-model' => 'officeSuite']);
    echo $this->Form->control('office_address', ['v-model' => 'officeStreetAddress']);
    echo $this->Form->control('office_city_id', ['options' => $cities, 'empty' => '- select city -', 'onChange' => 'app.officeCitySelected(this.text)']);
    echo $this->Form->control('office_province', ['disabled' => true]);
    echo $this->Form->control('office_postal_code', ['v-model' => 'officePostalCode']);
    echo $this->Form->control('work_phone', ['label' => 'Office Phone', 'v-model' => 'officePhone']);
    echo $this->Form->control('work_extension', ['label' => 'Office Phone Extension', 'v-model' => 'officeExtension']);

?>
       <a class="btn btn-primary" href="#homeAddressAnchor" v-on:click="showHomeAddressInput">Office Address Input</a><a id="officeAddressAnchor"></a>
   </fieldset>
</transition>

<transition name="fade">
   <fieldset id="homeAddress" v-show="officeAddressInput">

<?php

    echo $this->Form->control('home_suite', ['label' => 'Suite', 'v-model' => 'homeSuite']);
    echo $this->Form->control('home_address', ['v-model' => 'homeStreetAddress']);
    echo $this->Form->control('home_city_id', ['options' => $cities, 'empty' => '- select city -', 'onChange' => 'app.homeCitySelected()']);
    echo $this->Form->control('home_province', ['disabled' => true]);
    echo $this->Form->control('home_postal_code', ['v-model' => 'homePostalCode']);
    echo $this->Form->control('home_phone', ['v-model' => 'homePhone']);

?>

       <a class="btn btn-primary" href="#supervisor" v-on:click="showSupervisorInput">Home Address Input</a><a id="homeAddressAnchor"></a>
   </fieldset>
</transition>

<transition name="fade">
   <fieldset id="supervisor" v-if="homeAddressInput">

<?php

    echo $this->Form->control('supervisor_first_name', ['v-model' => 'supervisorFirstName']);
    echo $this->Form->control('supervisor_last_name', ['v-model' => 'supervisorLastName']);
    echo $this->Form->control('supervisor_careof', ['label' => 'Floor / Room / Care Of', 'v-model' => 'supervisorMailPrefix']);
    echo $this->Form->control('supervisor_suite', ['label' => 'Suite', 'v-model' => 'supervisorSuite']);
    echo $this->Form->control('supervisor_address', ['v-model' => 'supervisorStreetAddress']);
    echo $this->Form->control('supervisor_city_id', ['options' => $cities, 'empty' => '- select city -', 'onChange' => 'app.supervisorCitySelected()']);
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

       <p>Milestone: {{ milestone }}</p>
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
                       <img alt="..." class="card-img-top" v-bind:src="'/img/awards/' + awardImage">
                       <div class="card-body">
                           <h5 class="card-title">{{awardName}}</h5>
                           <p class="card-text">{{awardDescription}}</p>
                           <p class="card-text">
                               <ul id="award-options">
                                <li v-for="option in awardOptions">
                                    {{ option }}
                                </li>
                               </ul>
                           </p>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-sm-6">
               <p class="divisionMinistryDisplay">You work in
                   {{branch}}
                   at
                   {{ministry}}</p>
               <p class="retirementDisplay" v-if="isRetiringThisYear">You are retiring on
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
           </div>
           <a class="btn btn-primary" href="#register" id="confirmInfo" v-on:click="showDeclaration">Confirm</a>

   </div>
</transition>

<transition name="fade">
   <div class="confirmationDisplay" v-if="informationConfirmed">
       <div class="row" id="declaration" v-if="informationConfirmed">
           <div class="col-sm-10">
               <h5>Declaration and Notice of Collection, Consent and Authorize</h5>
               <p class="collectionStatement">I declare, to the best of my knowledge and consistent with the Long Service Awards eligibility guidelines (which I have reviewed) that as of December 31, 2019, I will have worked for the BC Public Service for 25, 30, 35, 40, 45 or 50 years and I am therefore eligible for a Long Service Award. By providing my personal information, I am allowing the BC Public Service Agency to use and disclose this information for the planning and delivery of the Long Service Award recognition events. This personal information is required to process your application for the Long Service Awards and is collected in accordance with section 26(c) of the Freedom of Information and Protection of Privacy Act (FOIPPA). Questions about the collection or use of this information can be directed to EmployeeNews@gov.bc.ca, 1st floor- 563 Superior Street, Victoria BC, V8V 0C5</p>
               <div class="form-check">
                   <input class="form-check-input" id="agreedToDeclaration" type="checkbox" value="true">
                   <label class="form-check-label" for="agreedToDeclaration">I agree to the above declaration and its terms</label>
               </div>
           </div>
       </div>
       <div id="register">
       <?php
       echo $this->Form->button(__('Register'));
       echo $this->Form->button('Cancel', array(
           'type' => 'button',
           'onclick' => 'location.href=\'/registrations\''
       ));
       ?>
       </div>
   </div>
</transition>
    <div>
<?php

echo $this->Form->end();
?>

    </div>


    <modal v-if="showOptions" @close="showOptions = false">
        <!--
          you can use custom content here to overwrite
          default content
        -->
        <h3 slot="header">Award Options</h3>
    </modal>


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

    var awards=<?php echo json_encode($awardinfo); ?>;


    $(function () {
        $('#datetimepicker1').datetimepicker({format: 'L'});
    });

    function selectAward(award) {
        // store award id in hidden field so it gets saved on submit
        $('input[name=award_id]').val(award);

        for (var i = 0; i < awards.length; i++) {
            if (awards[i].id == award) {
                app.awardName = awards[i].name;
                app.awardDescription = awards[i].description;
                app.awardImage = awards[i].image;
            }
        }
        // check if it is a donation
        if (award == 0) {
            app.awardName = "Charitiable Donation";
            app.awardDescription = "Hey let's just give some money to PECSF!";
            app.awardImage = '25_pecsf.jpg';
        }
        app.selectAwardOptions(award);
    }



    Vue.config.devtools = true;


    var app = new Vue({
        el: "#app",
        data: {
            isRetiringThisYear: false,
            retirementStatusKnown: false,
            retirementDate: '',
            yearsOfService: 0,
            milestoneKnown: false,
            milestone: '',

            employeeID: '',
            firstName: '',
            lastName: '',
            ministry: '',
            branch: '',

            govtEmail: '',
            altEmail: '',

            officeMailPrefix: '',
            officeSuite: '',
            officeStreetAddress: '',
            officeCity: '',
            officePostalCode: '',
            officePhone: '',
            officeExtension: '',

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
            supervisorEmail: '',

            availableAwards: '[display available awards]',

            awardName: '',
            awardDescription: '',
            awardOptions: ['option 1', 'option 2'],
            awardImage: 'Watches-group-thumb.png',

            selectAward: false,
            awardSelected: false,
            identifyingInfoInput: false,
            officeAddressInput: false,
            homeAddressInput: false,
            supervisorInput: false,
            informationConfirmed: false,
            showOptions: true
        },
        methods: {

            getAward: function (select_id) {
              award = 0;
              for (var i = 0; i < awards.length; i++) {
                if (awards[i].id == select_id) {
                  award = awards[i];
                }
              }
              return award;
            },

            selectAwardOptions: function (select_id) {
              console.log('Select award options for award: ' + select_id);
              award = this.getAward(select_id);
console.log(award);
              console.log(award.options);
              console.log("=====");
              options = JSON.parse(award.options);
              console.log(options);
              console.log("size: " + options.length);
              options.forEach((element, index, array) => {
                console.log("name: " + element.name);
                console.log("type: " + element.type);
                if (element.type == "choice") {
                  console.log(element.values);
                }
              });
              //
              // for (var i = 0; i < award.length; i++) {
              //   console.log(award[i]);
              // }
              this.showOptions = true;
            },


            milestoneSelected: function (milestone) {
                this.exposeAwardSelector(milestone);

                var sel = document.getElementById("milestone-id");
                this.milestone = sel.options[sel.selectedIndex].text;

                console.log(awards);

                var awardDisplay = "";

                awardDisplay += '<div class="lsa-award">';
                awardDisplay += '<div class="lsa-award-image">';
                awardDisplay += '<img alt="..." src="/img/awards/25_pecsf.jpg">';
                awardDisplay += '</div>';

                awardDisplay += '<div class="lsa-award-name">Charitible Donation</div>';
                awardDisplay += '<div class="lsa-award-description">Instead of choosing an award from the catalogue, you can opt to make a charitable donation via the Provincial Employees Community Services Fund. A framed certificate of service, signed by the Premier of British Columbia, will be presented to you noting your charitable contribution. </div>';
                awardDisplay += '<a class="btn btn-primary" onclick="selectAward(0)">Select Donation</a>'
                awardDisplay += '</div>';

                for (var i = 0; i < awards.length; i++) {
                    if (awards[i].milestone_id == milestone) {
                        awardDisplay += '<div class="lsa-award">';
                        awardDisplay += '<div class="lsa-award-image">';
                        if (awards[i].image) {
                            awardDisplay += '<img alt="..." src="/img/awards/' + awards[i].image + '">';
                        }
                        else {
                            awardDisplay += '<img alt="..." src="http://placeimg.com/250/250/arch">';
                        }
                        awardDisplay += '</div>';

                        awardDisplay += '<div class="lsa-award-name">' + awards[i].name + '</div>';
                        awardDisplay += '<div class="lsa-award-description">' + awards[i].description + '</div>';
                        awardDisplay += '<a class="btn btn-primary" onclick="selectAward(' + awards[i].id + ')">Select Award</a>'
                        awardDisplay += '</div>';
                    }
                }

                this.availableAwards = awardDisplay;


            },


            officeCitySelected: function () {
                var sel = document.getElementById("office-city-id");
                this.officeCity = sel.options[sel.selectedIndex].text;
            },

            homeCitySelected: function () {
                var sel = document.getElementById("home-city-id");
                this.homeCity = sel.options[sel.selectedIndex].text;
            },

            supervisorCitySelected: function () {
                var sel = document.getElementById("supervisor-city-id");
                app.supervisorCity = sel.options[sel.selectedIndex].text;
            },

            ministrySelected: function () {
                var sel = document.getElementById("ministry-id");
                app.ministry = sel.options[sel.selectedIndex].text;
            },

            buttonMissedCeremony: function (missed) {
                if (missed == 1) {
                    this.selectAward = false;
                    this.showIdentifyingInfoInputs();
                }
                else {
                    this.selectAward = true;
                }
            },

            buttonRetirementClick: function (retiring) {
                $('input[name=retiring_this_year]').val(retiring);
                if (retiring == 1) {
                    this.exposeRetirementDatePicker();
                }
                else {
                    this.setRetirementStatusKnown();
                }
            },

            exposeRetirementDatePicker: function () {
                this.isRetiringThisYear = true;
                this.retirementStatusKnown = true;
            },

            setRetirementStatusKnown: function () {
                this.isRetiringThisYear = false;
                this.retirementStatusKnown = true;
            },

            exposeAwardSelector: function(milestone) {
                this.milestoneKnown = true;
            },

            showIdentifyingInfoInputs: function () {
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


</script>
