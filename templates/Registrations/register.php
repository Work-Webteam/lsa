<div class="container" id="app">
    <h1>Register for Long Service Award</h1>

    <?php
        echo $this->Form->create($registration);
    ?>

    <transition name="fade">
        <div class="form-group">
            <?php

                echo $this->Form->hidden('award_options', ['value' => '']);
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
        </div>
    </transition>

    <transition name="fade">
        <div class="form-group" v-if="awardSelected">
            <a id="selected-award" class="btn btn-primary" href="#identifyingInfo" v-on:click="showIdentifyingInfoInputs">Selected Award</a>
        </div>
    </transition>


    <transition name="fade">
        <fieldset id="identifyingInfo" v-show="awardConfirmed">
            <?php

            echo $this->Form->control('employee_id', ['label' => 'Employee ID', 'type' => 'text', 'v-model' => 'employeeID']);
            echo $this->Form->control('first_name', ['v-model' => 'firstName']);
            echo $this->Form->control('last_name', ['v-model' => 'lastName']);

            echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => '- select ministry -', 'onChange' => 'app.ministrySelected()']);
            echo $this->Form->control('department', ['label' => 'Branch', 'v-model' => 'ministryBranch']);

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
            <div>
                <span v-html="errorsEmployee" class="lsa-errors-container">
                </span>
            </div>
            <a id="id-info-input" class="btn btn-primary" href="#officeAddressAnchor" v-on:click="showOfficeAddressInput">ID Info Input</a>
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
            echo $this->Form->control('office_postal_code', ['v-model' => 'officePostalCode', 'text-transform' => 'uppercase']);
            echo $this->Form->control('work_phone', ['label' => 'Office Phone', 'v-model' => 'officePhone']);
            echo $this->Form->control('work_extension', ['label' => 'Office Phone Extension', 'v-model' => 'officeExtension']);

            ?>

            <div>
                <span v-html="errorsOffice" class="lsa-errors-container">
                </span>
            </div>
            <a id="office-address-input" class="btn btn-primary" href="#homeAddressAnchor" v-on:click="showHomeAddressInput">Office Address Input</a><a id="officeAddressAnchor"></a>
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
            <div>
                <span v-html="errorsHome" class="lsa-errors-container">
                </span>
            </div>
            <a id="home-address=input" class="btn btn-primary" href="#supervisor" v-on:click="showSupervisorInput">Home Address Input</a><a id="homeAddressAnchor"></a>
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
            <div>
                <span v-html="errorsSupervisor" class="lsa-errors-container">
                </span>
            </div>
            <a id="supervisor-input" class="btn btn-primary" href="#confirmInfo" v-on:click="showConfirmation">Supervisor Input</a>
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
                        {{ministryBranch}}
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

    <div aria-hidden="true" aria-labelledby="Awards" class="modal fade" id="award-1"  data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="awardName" class="modal-title">Award The First</h5>
                </div>
                <div class="modal-body">
                    <fieldset id="formAwardOptions">
                    </fieldset>
                </div>
                <div id="pop-up-errors">
                        <span v-html="errorsOptions" class="lsa-errors-container">
                        </span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" v-on:click="processOptions">Select</button>
                </div>
            </div>
        </div>
    </div>

    <div aria-hidden="true" aria-labelledby="Donations" class="modal fade" id="donation-1"  data-backdrop="static" data-keyboard="false"  role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="donationName" class="modal-title">Charitable Donation</h5>
                </div>
                <div class="modal-body">
                    <fieldset id="formDonationOptions">
                        <?php
                        echo $this->Form->control('selectedRegion', ['options' => $regions, 'empty' => '- select region -', 'onChange' => 'app.regionSelected()']);
                        ?>

                        <div id="donation-type" v-if="inputDonationType">
                            <label>Donate to</label>
                            <?php echo $this->Form->radio('selectDonationType', ['PECSF Region Charity Fund', 'One Individual Charity', 'Two Individual Charities'], ['onChange' => 'app.donationTypeSelected()']); ?>
                        </div>
                        <div v-if="inputCharity1">
                            <select id="selectedCharity1">
                                <option value>- select charity -</option>
                                <option v-for='data in availableCharities' :value='data.id'>{{ data.name }}</option>
                            </select>
                        </div>
                        <div v-if="inputCharity2">
                            <select id="selectedCharity2">
                                <option value>- select charity -</option>
                                <option v-for='data in availableCharities' :value='data.id'>{{ data.name }}</option>
                            </select>
                        </div>

                    </fieldset>
                </div>
                <div id="pop-up-errors">
                        <span v-html="errorsOptions" class="lsa-errors-container">
                        </span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" v-on:click="processOptions">Select</button>
                </div>
            </div>
        </div>
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

    var clrError = "#ff0000";
    var clrDefault = "#d1d1d1";

    var awards=<?php echo json_encode($awardinfo); ?>;
    var milestones=<?php echo json_encode($milestoneinfo); ?>;
    var regions=<?php echo json_encode($regions); ?>;
    var allCharities=<?php echo json_encode($charities); ?>;

    $(function () {
        $('#datetimepicker1').datetimepicker({format: 'L'});
    });


    function selectAward(award_id) {
        // store award id in hidden field so it gets saved on submit
        $('input[name=award_id]').val(award_id);

        award = app.getAward(award_id);

        $('#lsa-award-'+ app.selectedAward).css('background-color', 'transparent');
        // check if it is a donation
        if (award == 0) {
            app.awardName = "Charitiable Donation";
            app.awardDescription = "Donate $### to PECSF.";
            app.awardImage = '25_pecsf.jpg';
            $('#lsa-award-0').css('background-color', 'lightblue');
            app.selectCharityOptions();
        }
        else {
            app.awardName = award.name;
            app.awardDescription = award.description;
            app.awardImage = award.image;
            $('#lsa-award-'+award_id).css('background-color', 'lightblue');
            app.selectAwardOptions(award_id);
        }

        app.awardSelected = true;
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
            ministryBranch: '',

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
            availableAwardOptions: '[display available options]',

            selectedAward: -1,
            awardName: '',
            awardDescription: '',
            awardOptions: [],
            awardImage: 'Watches-group-thumb.png',

            availableCharities: [],
            donationRegion: '',
            donationCharity1: '',
            donationCharity2: '',

            errorsEmployee: '',
            errorsOffice: '',
            errorsHome: '',
            errorsSupervisor: '',
            errorsOptions: '',

            selectAward: false,
            awardSelected: false,
            awardConfirmed: false,
            identifyingInfoInput: false,
            officeAddressInput: false,
            homeAddressInput: false,
            supervisorInput: false,
            informationConfirmed: false,
            showOptions: true,

            inputDonationType: false,
            inputCharity1: false,
            inputCharity2: false,
            testShow: false
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

            getCharity: function (select_id) {
                charity = 0;
                for (var i = 0; i < allCharities.length; i++) {
                    if (allCharities[i].id == select_id) {
                        charity = allCharities[i];
                    }
                }
                return charity;
            },

            selectCharityOptions: function (select_id) {
                $("#donation-1").modal('show');
                this.selectedAward = 0;
            },

            regionSelected: function () {
                this.donationRegion = $('#selectedregion :selected').text();

                this.availableCharities = [];
                for (var i = 0; i < allCharities.length; i++) {
                    if (allCharities[i].pecsf_region_id == $('#selectedregion').val()) {
                        this.availableCharities.push(allCharities[i]);
                    }
                }
                this.inputDonationType = true;
            },

            donationTypeSelected: function() {
                if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
                    this.inputCharity1 = false;
                    this.inputCharity2 = false;
                }
                else if ($("input:radio[name ='selectDonationType']:checked").val() == 1) {
                    this.inputCharity1 = true;
                    this.inputCharity2 = false;
                }
                else if ($("input:radio[name ='selectDonationType']:checked").val() == 2) {
                    this.inputCharity1 = true;
                    this.inputCharity2 = true;
                }
            },

            selectAwardOptions: function (select_id) {
                award = this.getAward(select_id);
                options = JSON.parse(award.options);
                if (options.length > 0) {
                    if (this.selectedAward != award.id) {
                        jQuery('#formAwardOptions').empty();

                        availableOptions = "";
                        options.forEach((element, index, array) => {
                            availableOptions += "<p>" + element.name + "</p>";
                            if (element.type == "choice") {
                                input = '<label for="award-option-' + index + '">' + element.name + '</label>';
                                input += '<select id="award-option-' + index + '" requires="required">';
                                input += '<option value>- select option -</option>';

                                for (var i = 0; i < element.values.length; i++) {
                                    optionValue = element.values[i];
                                    input += '<option value="' + i + '">' + element.values[i] + '</option>';
                                }

                                input += '</select>';
                                jQuery('#formAwardOptions').append(input);
                            }
                            if (element.type == "text") {
                                input = '<label for="award-option-' + index + '">' + element.name + '</label>';
                                input += '<input type="text" id="award-option-' + index + '">';
                                jQuery('#formAwardOptions').append(input);
                            }
                        });
                    }
                    $("#awardName").html(award.name);
                    $("#award-1").modal('show');
                }
                this.selectedAward = award.id;
            },

            processOptions: function () {
                if (this.selectedAward == 0) {
                    this.processDonationOptions();
                }
                else {
                    this.processAwardOptions();
                }
            },

            processDonationOptions: function() {

                for (var i = 0; i < milestones.length; i++) {
                    if (milestones[i].id == $('#milestone-id').val()) {
                        milestone = milestones[i];
                    }
                }

                errors = [];

                this.awardOptions = [];
                $('#donation-type').css("border-color", clrDefault);
                if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
                    amount = milestone.donation;
                    this.awardOptions.push(this.currencyFormat(amount) + " Donation - PECSF Region Charity Fund");
                }
                else if ($("input:radio[name ='selectDonationType']:checked").val() == 1) {
                    if ($('#selectedCharity1').val() == 0) {
                        errors.push("Charity is required");
                        $('#selectedCharity1').css("border-color", clrError);
                    }
                    else {
                        amount = milestone.donation;
                        charity = this.getCharity($('#selectedCharity1').val());
                        this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") " + charity.name);
                        $('#selectedCharity1').css("border-color", clrDefault);
                    }

                }
                else if ($("input:radio[name ='selectDonationType']:checked").val() == 2) {
                    amount = milestone.donation / 2;

                    if ($('#selectedCharity1').val() == 0) {
                        errors.push("First Charity is required");
                        $('#selectedCharity1').css("border-color", clrError);
                    }
                    else {
                        charity = this.getCharity($('#selectedCharity1').val());
                        this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") "  + charity.name);
                        $('#selectedCharity1').css("border-color", clrDefault);
                    }

                    if ($('#selectedCharity2').val() == 0) {
                        errors.push("Second Charity is required");
                        $('#selectedCharity2').css("border-color", clrError);
                    }
                    else {
                        charity = this.getCharity($('#selectedCharity2').val());
                        this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") "  + charity.name);
                        $('#selectedCharity2').css("border-color", clrDefault);
                    }
                }
                else {
                    if (this.inputDonationType) {
                        errors.push('Please select the type of donation.');
                        $('#donation-type').css("border-color", clrError);
                    }
                }

                if (document.getElementById("selectedregion").selectedIndex == 0) {
                    errors.push('Region is required');
                    $('#selectedregion').css("border-color", clrError);
                }
                else {
                    $('#selectedregion').css("border-color", clrDefault);
                }

                if (errors.length == 0) {
                    $('input[name=award_options]').val(JSON.stringify(this.awardOptions));
                    $("#donation-1").modal('hide');
                    this.errorsOptions = '';
                }
                else {
                    this.errorsOptions = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsOptions += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsOptions += '</ul>';
                }

            },


            processAwardOptions: function () {
                award = this.getAward(this.selectedAward);
                options = JSON.parse(award.options);

                errors = [];

                this.awardOptions = [];
                for (i = 0; i < options.length; i++) {
                    if (options[i].type == "choice") {
                        var sel = document.getElementById("award-option-"+i);
                        if (sel.selectedIndex == 0) {
                            errors.push(options[i].name + " is required");
                        }
                        else {
                            this.awardOptions.push(options[i].name + ": " + sel.options[sel.selectedIndex].text);
                        }
                    }
                    if (options[i].type == "text") {
                        var field = document.getElementById("award-option-"+i);
                        if (field.value) {
                            this.awardOptions.push(options[i].name + ": " + field.value);
                        }
                        else {
                            errors.push(options[i].name + " is required");
                        }
                    }
                }

                if (errors.length == 0) {
                    $('input[name=award_options]').val(JSON.stringify(this.awardOptions));
                    $("#award-1").modal('hide');
                    this.errorsOptions = '';
                }
                else {
                    this.errorsOptions = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsOptions += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsOptions += '</ul>';
                }
            },

            milestoneSelected: function (milestone) {
                this.exposeAwardSelector(milestone);

                var sel = document.getElementById("milestone-id");
                this.milestone = sel.options[sel.selectedIndex].text;

                var awardDisplay = "";

                awardDisplay += '<div id="lsa-award-0" class="lsa-award">';
                awardDisplay += '<div class="lsa-award-image">';
                awardDisplay += '<img alt="..." src="/img/awards/25_pecsf.jpg">';
                awardDisplay += '</div>';

                awardDisplay += '<div class="lsa-award-name">Charitible Donation</div>';
                awardDisplay += '<div class="lsa-award-description">Instead of choosing an award from the catalogue, you can opt to make a charitable donation via the Provincial Employees Community Services Fund. A framed certificate of service, signed by the Premier of British Columbia, will be presented to you noting your charitable contribution. </div>';
                awardDisplay += '<a class="btn btn-primary" href="#" onclick="selectAward(0)">Select Donation</a>'
                awardDisplay += '</div>';

                for (var i = 0; i < awards.length; i++) {
                    if (awards[i].milestone_id == milestone) {
                        awardDisplay += '<div id="lsa-award-' + awards[i].id + '" class="lsa-award">';
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
                        awardDisplay += '<button class="btn btn-primary" type="button" onclick="selectAward(' + awards[i].id + ')">Select Award</button>';
                        awardDisplay += '</div>';
                    }
                }

                this.availableAwards = awardDisplay;


            },


            officeCitySelected: function () {
                var sel = document.getElementById("office-city-id");
                if (sel.selectedIndex > 0) {
                    this.officeCity = sel.options[sel.selectedIndex].text;
                }
                else {
                    this.officeCity = '';
                }

            },

            homeCitySelected: function () {
                var sel = document.getElementById("home-city-id");
                if (sel.selectedIndex > 0) {
                    this.homeCity = sel.options[sel.selectedIndex].text;
                }
                else {
                    this.homeCity = '';
                }
            },

            supervisorCitySelected: function () {
                var sel = document.getElementById("supervisor-city-id");
                if (sel.selectedIndex > 0) {
                    this.supervisorCity = sel.options[sel.selectedIndex].text;
                }
                else {
                    this.supervisorCity = '';
                }
            },

            ministrySelected: function () {
                var sel = document.getElementById("ministry-id");
                if (sel.selectedIndex > 0) {
                    this.ministry = sel.options[sel.selectedIndex].text;
                }
                else {
                    this.ministry = '';
                }
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
                this.awardConfirmed = true;
            },

            showOfficeAddressInput: function () {

                errors = this.checkIdentifyingInfo();
                if (errors.length == 0) {
                    $('#id-info-input').attr("href", "#officeAddressAnchor");
                    this.identifyingInfoInput = true;
                    this.errorsEmployee = '';
                }
                else {
                    $('#id-info-input').attr("href", "#identifyingInfo");
                    this.errorsEmployee = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsEmployee += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsEmployee += '</ul>';
                }
            },

            showHomeAddressInput: function () {

                errors = this.checkOfficeAddressInput();
                if (errors.length == 0) {
                    $('#office-address-input').attr("href", "#homeAddressAnchor");
                    this.officeAddressInput = true;
                    this.errorsOffice = '';
                }
                else {
                    $('#office-address-input').attr("href", "#officeAddressAnchor");
                    this.errorsOffice = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsOffice += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsOffice += '</ul>';
                }
            },

            showSupervisorInput: function () {
                errors = this.checkHomeAddressInput();
                if (errors.length == 0) {
                    $('#home-address-input').attr("href", "#supervisor");
                    this.homeAddressInput = true;
                    this.errorsHome = '';
                }
                else {
                    $('#home-address-input').attr("href", "#homeAddressAnchor");
                    this.errorsHome = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsHome += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsHome += '</ul>';
                }
            },

            showConfirmation: function () {
                errors = this.checkSupervisorInput();
                if (errors.length == 0) {
                    $('#home-address-input').attr("href", "#confirmationInfo");
                    this.supervisorInput = true;
                    this.errorsSupervisor = '';
                }
                else {
                    $('#home-address-input').attr("href", "#supervisor");
                    this.errorsSupervisor = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsSupervisor += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsSupervisor += '</ul>';
                }
            },

            showDeclaration: function () {
                this.informationConfirmed = true;
            },

            currencyFormat: function (num) {
                return '$' + parseFloat(num).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },

            checkIdentifyingInfo: function () {

                var error = [];

                if (!this.employeeID) {
                    $('#employee-id').css("border-color", clrError);
                    error.push('Employee ID is required');
                }
                else {
                    $('#employee-id').css("border-color", clrDefault);
                }

                if (!this.firstName) {
                    $('#first-name').css("border-color", clrError);
                    error.push('Employee first name is required');
                }
                else {
                    $('#first-name').css("border-color", clrDefault);
                }

                if (!this.lastName) {
                    $('#last-name').css("border-color", clrError);
                    error.push('Employee last name is required');
                }
                else {
                    $('#last-name').css("border-color", clrDefault);
                }

                if (!this.ministry) {
                    $('#ministry-id').css("border-color", clrError);
                    error.push('Ministry is required');
                }
                else {
                    $('#ministry-id').css("border-color", clrDefault);
                }

                if (!this.ministryBranch) {
                    $('#department').css("border-color", clrError);
                    error.push('Branch is required');
                }
                else {
                    $('#department').css("border-color", clrDefault);
                }

                if (!this.govtEmail) {
                    $('#preferred-email').css("border-color", clrError);
                    error.push('Government Email is required.');
                }
                else {
                    if (!isEmail(this.govtEmail)) {
                        $('#preferred-email').css("border-color", clrError);
                        error.push('Government Email invalid format');
                    }
                    else {
                        $('#preferred-email').css("border-color", clrDefault);
                    }
                }

                if (this.altEmail) {
                    if (!isEmail(this.altEmail)) {
                        $('#alternate-email').css("border-color", clrError);
                        error.push('Alternate Email invalid format');
                    } else {
                        $('#alternate-email').css("border-color", clrDefault);
                    }
                }

                return error;
            },

            checkOfficeAddressInput: function () {

                var error = [];

                if (!this.officeStreetAddress) {
                    $('#office-address').css("border-color", clrError);
                    error.push('Office Address is required');
                }
                else {
                    $('#office-address').css("border-color", clrDefault);
                }

                if (!this.officeCity) {
                    $('#office-city-id').css("border-color", clrError);
                    error.push ('Office City is required');
                }
                else {
                    $('#office-city-id').css("border-color", clrDefault);
                }

                if (!this.officePostalCode) {
                    $('#office-postal-code').css("border-color", clrError);
                    error.push ('Office Postal Code is required');
                }
                else {
                    if (!isPostalCode(this.officePostalCode)) {
                        $('#office-postal-code').css("border-color", clrError);
                        error.push ('Office Postal Code invalid format');
                    }
                    else {
                        $('#office-postal-code').css("border-color", clrDefault);
                    }
                }

                if (!this.officePhone) {
                    $('#work-phone').css("border-color", clrError);
                    error.push ('Office Phone number is required');
                }
                else {
                   if (!isPhone(this.officePhone)) {
                       $('#work-phone').css("border-color", clrError);
                       error.push ('Office Phone number invalid format. (###) ###-####');
                   }
                   else {
                       $('#work-phone').css("border-color", clrDefault);
                   }
                }

                return error;
            },

            checkHomeAddressInput: function () {

                var error = [];

                if (!this.homeStreetAddress) {
                    $('#home-address').css("border-color", clrError);
                    error.push('Home Address is required');
                }
                else {
                    $('#home-address').css("border-color", clrDefault);
                }

                if (!this.homeCity) {
                    $('#home-city-id').css("border-color", clrError);
                    error.push('Home City is required');
                }
                else {
                    $('#home-city-id').css("border-color", clrDefault);
                }

                if (!this.homePostalCode) {
                    $('#home-postal-code').css("border-color", clrError);
                    error.push('Home Postal Code is required');
                }
                else {
                    if (!isPostalCode(this.homePostalCode)) {
                        $('#home-postal-code').css("border-color", clrError);
                        error.push('Home Postal Code invalid format');
                    }
                    else {
                        $('#home-postal-code').css("border-color", clrDefault);
                    }
                }

                if (!this.homePhone) {
                    $('#home-phone').css("border-color", clrError);
                    error.push('Home Phone number is required');
                }
                else {
                    if (!isPhone(this.homePhone)) {
                        $('#home-phone').css("border-color", clrError);
                        error.push('Home Phone number invalid format. (###) ###-####');
                    }
                    else {
                        $('#home-phone').css("border-color", clrDefault);
                    }
                }

                return error;
            },


            checkSupervisorInput: function () {

                var error = [];

                if (!this.supervisorFirstName) {
                    $('#supervisor-first-name').css("border-color", clrError);
                    error.push('Supervisor First Name is required');
                }
                else {
                    $('#supervisor-first-name').css("border-color", clrDefault);
                }

                if (!this.supervisorLastName) {
                    $('#supervisor-last-name').css("border-color", clrError);
                    error.push('Supervisor last name is required');
                }
                else {
                    $('#supervisor-last-name').css("border-color", clrDefault);
                }

                if (!this.supervisorStreetAddress) {
                    $('#supervisor-address').css("border-color", clrError);
                    error.push('Supervisor Address is required');
                }
                else {
                    $('#supervisor-address').css("border-color", clrDefault);
                }

                if (!this.supervisorCity) {
                    $('#supervisor-city-id').css("border-color", clrError);
                    error.push('Supervisor City is required');
                }
                else {
                    $('#supervisor-city-id').css("border-color", clrDefault);
                }

                if (!this.supervisorPostalCode) {
                    $('#supervisor-postal-code').css("border-color", clrError);
                    error.push('Supervisor Postal Code is required');
                }
                else {
                    if (!isPostalCode(this.supervisorPostalCode)) {
                        $('#supervisor-postal-code').css("border-color", clrError);
                        error.push('Supervisor Postal Code invalid format');
                    }
                    else {
                        $('#supervisor-postal-code').css("border-color", clrDefault);
                    }
                }

                if (!this.supervisorEmail) {
                    $('#supervisor-email').css("border-color", clrError);
                    error.push('Supervisor Email is required');
                }
                else {
                    if (!isEmail(this.supervisorEmail)) {
                        $('#supervisor-email').css("border-color", clrError);
                        error.push('Supervisor Email invalid format');
                    }
                    else {
                        $('#supervisor-email').css("border-color", clrDefault);
                    }
                }

                return error;
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

    var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 1500
    });


</script>


