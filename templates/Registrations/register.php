




<div id="app">
    <v-app>
        <v-main>
            <v-container>
                <v-stepper v-model="e1">
                    <v-stepper-header>
                        <v-stepper-step :complete="e1 > 1" step="1"> Milestone</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 2" step="2"> Award</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 3" step="3"> Contact <br> <span class="step-name-subtext">Employee</span></v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 4" step="4"> Contact <br> <span class="step-name-subtext">Supervisor</span></v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 5" step="5"> Confirm </v-stepper-step>
                    </v-stepper-header>

                    <v-stepper-items>
                        <v-stepper-content step="1">
                            <h3 class="display-3">Milestone</h3>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="milestone">Which milestone are you celebrating?</label>
                                        <select class="form-control" id="milestone" name="milestone">
                                           <?php foreach($milestoneInfo as $milestone) : ?>
                                            <option value="<?= $milestone->id ?>"><?= $milestone->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">I which year did you reach this milestone?</label>
                                        <select class="form-control" id="" name="" >
                                            <option selected disabled>Select Year</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How would you like your name to appear on your certificate?</label>
                                        <input type="text" id="" name="" class="form-control" v-model="">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Did you register for a Long Service Award last year, but not attend a ceremony?</label>
                                        <input class="form-check-input" type="radio" name="" id="" value="">
                                        <label class="form-check-label" for="">Yes</label>
                                        <input class="form-check-input" type="radio" name="" id="" value="">
                                        <label class="form-check-label" for="">No</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Are you retiring this calendar year? </label>
                                        <input class="form-check-input" type="radio" name="" id="" value="true" v-model="isRetiringThisYear">
                                        <label class="form-check-label" for="">Yes</label>
                                        <input class="form-check-input" type="radio" name="" id="" value="false" v-model="isRetiringThisYear">
                                        <label class="form-check-label" for="">No</label>
                                    </div>
                                </div>
                            </div>



                            <button class="btn btn-primary" @click="e1 = 2">Select Award</button>
                        </v-stepper-content>

                        <v-stepper-content step="2">

                            <button class="btn btn-primary" @click="e1 = 3">Enter Contact Information</button>
                        </v-stepper-content>


                        <v-stepper-content step="3">
                            <h3 class="display-3">Your Contact Information</h3>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Employee ID #</label>
                                        <input type="text" id="employee_id" name="employee_id" class="form-control" v-model="employeeID">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" id="first_name" name="first_name" v-model="firstName" class="form-control" placeholder="Your First Name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" v-model="lastName" class="form-control" placeholder="Your Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Government email address</label>
                                        <input type="email" id="preferred_email" name="preferred_email" v-model="govtEmail" class="form-control" placeholder="i.e. taylor.publicservant@gov.bc.ca">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Alternate email address</label>
                                        <input type="email" id="alternate_email" name="alternate_email" v-model="altEmail" class="form-control" placeholder="i.e. taylor_publicservant@gmail.com">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Current Ministry</label>
                                        <select name="ministry_id" id="ministry_id" @change="app.ministrySelected()" class="form-control">
                                            <option selected default>Choose your Ministry</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Current branch</label>
                                        <input type="text" id="branch" name="branch" v-model="ministryBranch" class="form-control" placeholder="i.e. Corporate Services">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <p>Are you retiring during this calendar year?</p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="" id="" value="">
                                        <label class="form-check-label" for="">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="" value="">
                                        <label class="form-check-label" for="">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <h4 class="display-2">Your Office Address</h4>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Floor/Room/Care Of</label>
                                        <input type="text" class="form-control" placeholder="i.e. Discovery Room">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Suite</label>
                                        <input type="text" class="form-control" placeholder="i.e. 800">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Street Address</label>
                                        <input type="text" class="form-control" placeholder="i.e. 1445 10th Ave.">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <select name="" id="" class="form-control">
                                            <option selected disabled>Choose city</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Postal Code</label>
                                        <input type="text" class="form-control" placeholder="i.e. A1A 1A1">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">

                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Office Phone Number</label>
                                        <input type="text" class="form-control" placeholder="i.e. (604) 555-5555">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div clas="form-group">
                                        <label for="">Extension</label>
                                        <input type="text" class="form-control" placeholder="ie. 800">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <h4 class="display-2">Your Home Address</h4>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Floor/Room/Care Of</label>
                                        <input type="text" class="form-control" placeholder="i.e. Discovery Room">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Suite</label>
                                        <input type="text" class="form-control" placeholder="i.e. 800">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Street Address</label>
                                        <input type="text" class="form-control" placeholder="i.e. 1445 10th Ave.">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <select name="" id="" class="form-control">
                                            <option selected disabled>Choose city</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Postal Code</label>
                                        <input type="text" class="form-control" placeholder="i.e. A1A 1A1">
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Office Phone Number</label>
                                        <input type="text" class="form-control" placeholder="i.e. (604) 555-5555">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div clas="form-group">
                                        <label for="">Extension</label>
                                        <input type="text" class="form-control" placeholder="ie. 800">
                                    </div>
                                </div>
                            </div>


                            <button class="btn btn-primary" @click="e1 = 4">Enter Supervisor's Contact Info.</button>
                        </v-stepper-content>

                        <v-stepper-content step="4">
                            <h3>Your Supervisor's Contact Information</h3>
                            <div class="form-row">

                            </div>



                        </v-stepper-content>

                        <v-stepper-content step="5">

                        </v-stepper-content>

                    </v-stepper-items>


                </v-stepper>
            </v-container>
        </v-main>
    </v-app>

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
<!-- Special JavaScript just for Registration form -->
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>


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
</script>

<script type="text/javascript">


    var app = new Vue({
        el: "#app",
        vuetify: new Vuetify(),
        data: {
            e1: 1,
            isRetiringThisYear: false,
            retirementStatusKnown: false,
            retirementDate: '',
            yearsOfService: 0,
            milestoneKnown: false,
            milestonePersonalized: false,
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

            availableAwards: '',
            availableAwardOptions: '',

            currentAwardName: '',
            currentAwardImage: '',
            currentAwardDescription: '',
            currentAwardIndex: 0,
            currentAwards: [],

            selectedAward: -1,
            awardName: '',
            awardDescription: '',
            awardOptions: [],
            awardImage: '',

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

            populateTestData: function () {

                if (this.employeeID == '99999') {
                    this.firstName = "Homer";
                    this.lastName = "Simpson";
                    sel = document.getElementById("ministry-id");
                    sel.selectedIndex = 16;
                    this.ministry = sel.options[sel.selectedIndex].text;
                    this.ministryBranch = "Branch 13";
                    this.govtEmail = "hsimpson@gov.bc.ca";
                    this.isRetiringThisYear = false;

                    this.officeStreetAddress = "123 Office Street";
                    var sel = document.getElementById("office-city-id");
                    sel.selectedIndex = 1997;
                    this.officeCity = sel.options[sel.selectedIndex].text;
                    this.officePostalCode = "V8V 4R6";
                    this.officePhone = "(250) 555-5476";

                    this.homeStreetAddress = "565 Home Street";
                    var sel = document.getElementById("home-city-id");
                    sel.selectedIndex = 1997;
                    this.homeCity = sel.options[sel.selectedIndex].text;
                    this.homePostalCode = "V8V 4R6";
                    this.homePhone = "(250) 555-0772";

                    this.supervisorFirstName = "Franklin";
                    this.supervisorLastName = "Hughes";
                    this.supervisorStreetAddress = "123 Office Street";
                    this.supervisorPostalCode = "V8V 4R6";
                    this.supervisorEmail = "fhughes@gov.bc.ca";
                    var sel = document.getElementById("supervisor-city-id");
                }
            },

            getMilestone: function (select_id) {
                milestone = 0;
                for (var i = 0; i < milestones.length; i++) {
                    if (milestones[i].id == select_id) {
                        milestone = milestones[i];
                    }
                }
                return milestone;
            },

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

            selectCharityOptions: function () {
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

                $('input[name=pecsf_donation]').val(1);


                $('input[name=pecsf_name]').val($('input[name=donorName').val());

                this.awardOptions = [];
                $('#donation-type').css("border-color", clrDefault);
                if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
                    amount = milestone.donation;
                    this.awardOptions.push(this.currencyFormat(amount) + " Donation - PECSF Region Charity Fund");
                    $('input[name=pecsf_amount1]').val(amount);
                    $('input[name=pecsf_donation_type]').val(0);
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
                        $('input[name=pecsf_charity1_id]').val(charity.id);
                        $('input[name=pecsf_amount1]').val(amount);
                    }
                    $('input[name=pecsf_donation_type]').val(1);
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
                        $('input[name=pecsf_charity1_id]').val(charity.id);
                        $('input[name=pecsf_amount1]').val(amount);
                    }

                    if ($('#selectedCharity2').val() == 0) {
                        errors.push("Second Charity is required");
                        $('#selectedCharity2').css("border-color", clrError);
                    }
                    else {
                        charity = this.getCharity($('#selectedCharity2').val());
                        this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") "  + charity.name);
                        $('#selectedCharity2').css("border-color", clrDefault);
                        $('input[name=pecsf_charity2_id]').val(charity.id);
                        $('input[name=pecsf_amount2]').val(amount);
                    }
                    $('input[name=pecsf_donation_type]').val(2);
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
                    $('input[name=pecsf_region_id]').val($('#selectedregion').val());
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
                    console.log(options[i]);
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
                            if (field.value.length <= options[i].maxlength) {
                               this.awardOptions.push(options[i].name + ": " + field.value);
                            }
                            else {
                               errors.push(options[i].name + " may not contain more than " + options[i].maxlength + " characters.");
                            }
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

                    // Reset PECSF Donation values in case user previous selected PECSF donation option
                    $('input[name=pecsf_region_id]').val(0);
                    $('input[name=pecsf_donation]').val(0);
                    $('input[name=pecsf_donation_type]').val(0);
                    $('input[name=pecsf_charity1_id]').val(0);
                    $('input[name=pecsf_amount1]').val(0);
                    $('input[name=pecsf_charity2_id]').val(0);
                    $('input[name=pecsf_amount2]').val(0);
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

                this.currentAwards = [];
                var donation = {
                    id: 0,
                    name: "PECSF Donation",
                    description: "Instead of choosing an award from the catalogue, you can opt to make a charitable donation via the Provincial Employees Community Services Fund. A framed certificate of service, signed by the Premier of British Columbia, will be presented to you noting your charitable contribution.",
                    image: "25_pecsf.jpg"
                };

                this.currentAwards.push(donation);

                for (var i = 0; i < awards.length; i++) {
                    if (awards[i].milestone_id == milestone) {
                        this.currentAwards.push(awards[i]);
                    }
                }

                this.currentAwardIndex = 0;
                this.updateAwardDisplay(this.currentAwardIndex);

                var record = this.getMilestone(milestone);
                this.milestonePersonalized = record.personalized;
                if (record.personalized) {
                    $('input[name=certificate_name]').val("");
                }
            },

            showPreviousAward: function() {
                this.currentAwardIndex--;
                if (this.currentAwardIndex < 0) {
                    this.currentAwardIndex = this.currentAwards.length - 1;
                }
                this.updateAwardDisplay(this.currentAwardIndex);
            },

            showNextAward: function() {
                this.currentAwardIndex++;
                if (this.currentAwardIndex >= this.currentAwards.length) {
                    this.currentAwardIndex = 0;
                }
                this.updateAwardDisplay(this.currentAwardIndex);
            },

            updateAwardDisplay: function(awardIndex) {
                this.currentAwardName = this.currentAwards[awardIndex].name;
                this.currentAwardImage = this.currentAwards[awardIndex].image;
                this.currentAwardDescription = nl2br(this.currentAwards[awardIndex].description);
                if (this.selectedAward == this.currentAwards[awardIndex].id) {
                    $('#lsa-award-card').css('background-color', 'lightblue');
                }
                else {
                    $('#lsa-award-card').css('background-color', 'transparent');
                }
            },


            selectCurrentAward: function() {

                award = this.currentAwards[this.currentAwardIndex];

                // store award id in hidden field so it gets saved on submit
                $('input[name=award_id]').val(award.id);

                // $('#lsa-award-'+ app.selectedAward).css('background-color', 'transparent');
                $('#lsa-award-card').css('background-color', 'lightblue');
                app.awardName = award.name;
                app.awardDescription = award.description;
                app.awardImage = award.image;

                // check if it is a donation
                if (award.id == 0) {
                    app.selectCharityOptions();
                }
                else {
                    app.selectAwardOptions(award.id);
                }

                this.selectedAward = award.id;

                app.awardConfirmed = true;
                $('html, body').animate({
                    scrollTop: $("#employeeAnchor").offset().top
                }, 1000);
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
                $('html, body').animate({
                    scrollTop: $("#employeeAnchor").offset().top
                }, 1000);
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
                    $('html, body').animate({
                        scrollTop: $("#officeAnchor").offset().top
                    }, 1000);

                    this.identifyingInfoInput = true;
                    this.errorsEmployee = '';
                }
                else {

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
                    $('html, body').animate({
                        scrollTop: $("#homeAnchor").offset().top
                    }, 1000);
                    this.officeAddressInput = true;
                    this.errorsOffice = '';
                }
                else {
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
                    $('html, body').animate({
                        scrollTop: $("#supervisorAnchor").offset().top
                    }, 1000);
                    this.homeAddressInput = true;
                    this.errorsHome = '';
                }
                else {
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
                    $('html, body').animate({
                        scrollTop: $("#confirmationAnchor").offset().top
                    }, 1000);
                    this.supervisorInput = true;
                    this.errorsSupervisor = '';
                }
                else {
                    this.errorsSupervisor = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsSupervisor += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsSupervisor += '</ul>';
                }
            },

            showDeclaration: function () {
                this.informationConfirmed = true;
                $('html, body').animate({
                    scrollTop: $("#declarationAnchor").offset().top
                }, 1000);
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
                    $('#branch').css("border-color", clrError);
                    error.push('Branch is required');
                }
                else {
                    $('#branch').css("border-color", clrDefault);
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
                        error.push ('Office Postal Code invalid format (A1A 1A1)');
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
                       error.push ('Office Phone number invalid format (###) ###-####');
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
                        error.push('Home Postal Code invalid format (A1A 1A1)');
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
                        error.push('Home Phone number invalid format (###) ###-####');
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
                        error.push('Supervisor Postal Code invalid format (A1A 1A1)');
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

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
    }

    var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 1500
    });

    Vue.config.devtools = true;


</script>
