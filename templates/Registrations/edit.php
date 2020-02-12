<div class="container" id="app">
<h1><?= $registration->first_name . " " . $registration->last_name ?></h1>



<?php
    use Cake\Core\Configure;

    echo $this->Form->create($registration, ['horizontal' => true]);
?>

    <tabs>

            <?php
                echo '<tab name="Recipient" :selected="true">';
                echo $this->Form->control('employee_id', ['type' => 'text', 'label' => 'Employee ID']);
                echo $this->Form->control('first_name');
                echo $this->Form->control('last_name');
                echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => '- select ministry -']);
                echo $this->Form->control('branch', ['label' => 'Branch']);
                echo $this->Form->control('preferred_email', ['label' => 'Government Email']);
                echo '</tab>';
            ?>

            <?php
                echo '<tab name="Award">';

                echo $this->Form->control('milestone_id', ['options' => $milestones]);
                echo $this->Form->control('award_id', ['options' => $awards]);

                if ($isadmin) {
                    echo $this->Form->control('award_year', ['label' => 'Award Year']);
                    echo $this->Form->control('award_received', ['type' => 'checkbox']);
                    echo $this->Form->control('engraving_sent', ['type' => 'checkbox']);
                    echo $this->Form->control('certificate_name');
                    echo $this->Form->control('certificate_ordered');
                    echo $this->Form->control('award_instructions', ['label' => 'Award Instructions', 'type' => 'textarea']);

                    echo '<div v-if="showPecsfDonation">';
                    echo $this->Form->control('pecsf_donation');
                    echo $this->Form->control('pecsf_region_id', ['options' => $regions]);

                    echo '<template v-if="showPecsfCharity1">';
                    echo $this->Form->control('pecsf_charity1_id', ['options' => $charities]);
                    echo '</template>';
                    echo '<template v-else>';
                    echo 'PECSF Regional Fund';
                    echo '</template>';
                    echo $this->Form->control('pecsf_amount1');
                    echo $this->Form->control('pecsf_second_charity');
                    echo '<div v-if="showPecsfCharity2">';
                    echo $this->Form->control('pecsf_charity2_id', ['options' => $charities]);
                    echo $this->Form->control('pecsf_amount2');
                    echo '</div>';

                    echo $this->Form->control('pecsf_cheque_date');
                    echo '</div>';
                }
                echo '</tab>';
            ?>


            <?php
            echo '<tab name="Office">';
                echo $this->Form->control('office_careof', ['label' => 'Floor/ Room / Care Of']);
                echo $this->Form->control('office_address', ['label' => 'Address']);
                echo $this->Form->control('office_suite', ['label' => 'Suite']);
                echo $this->Form->control('office_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                echo $this->Form->control('office_province', ['label' => 'Province']);
                echo $this->Form->control('office_postal_code', ['label' => 'Postal Code']);
                echo $this->Form->control('work_phone', ['label' => 'Phone']);
                echo $this->Form->control('work_extension', ['label' => 'Phone Extension']);
                echo '</tab>';
            ?>


            <?php
            echo '<tab name="Home">';
                echo $this->Form->control('home_address', ['label' => 'Address']);
                echo $this->Form->control('home_suite', ['label' => 'Suite']);
                echo $this->Form->control('home_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                echo $this->Form->control('home_province', ['label' => 'Province']);
                echo $this->Form->control('home_postal_code', ['label' => 'Postal Code']);
                echo $this->Form->control('home_phone', ['label' => 'Phone']);
                echo '</tab>';
            ?>


            <?php
            echo '<tab name="Supervisor">';
            echo $this->Form->control('supervisor_first_name', ['label' => 'First Name']);
            echo $this->Form->control('supervisor_last_name', ['label' => 'Last Name']);
            echo $this->Form->control('supervisor_careof', ['label' => 'Floor / Room / Care Of']);
            echo $this->Form->control('supervisor_address', ['label' => 'Address']);
            echo $this->Form->control('supervisor_suite', ['label' => 'Suite']);
            echo $this->Form->control('supervisor_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
            echo $this->Form->control('supervisor_province', ['label' => 'Province']);
            echo $this->Form->control('supervisor_postal_code', ['label' => 'Postal Code']);
            echo $this->Form->control('supervisor_email', ['label' => 'Email']);
            echo '</tab>';
            ?>


            <?php
                if ($isadmin) {
                    echo '<tab name="Ceremony">';
                    echo $this->Form->control('ceremony_id', ['label' => 'Ceremony Night', 'options' => $ceremonies, 'empty' => '- select ceremony -']);
//                    echo $this->Form->control('ceremony_date', ['disabled' => true]);
                    echo $this->Form->control('attending');
                    echo $this->Form->control('guest');
                    echo $this->Form->control('recipient_speaker');
                    echo $this->Form->control('reserved_seating');
                    echo $this->Form->control('executive_recipient');
                    echo $this->Form->control('presentation_number', ['label' => 'Award Presentation #']);
                    echo $this->Form->control('accessibility_requirements_recipient', ['label' => 'Recipient Accessibility Requirements', 'type' => 'checkbox']);
                    echo $this->Form->control('accessibility_requirements_guest', ['label' => 'Guest Accessibility Requirements', 'type' => 'checkbox']);
                    echo $this->Form->control('accessibility_recipient_notes');
                    echo $this->Form->control('accessibility_guest_notes');
                    echo $this->Form->control('accessibility_admin_notes');
                    echo $this->Form->control('recipient_diet_id', ['options' => $diet, 'empty' => '- select diet -']);
                    echo $this->Form->control('recipient_diet_other');
                    echo $this->Form->control('guest_diet_id', ['options' => $diet, 'empty' => '- select diet -']);
                    echo $this->Form->control('guest_diet_other');
                    echo '</tab>';
                }
            ?>

            <?php
                if ($isadmin) {
                    echo '<tab name="Admin">';
                    echo $this->Form->control('survey_participation');
                    echo $this->Form->control('created', ['disabled' => true]);
                    echo $this->Form->control('invite_sent', ['type' => 'date']);
                    echo $this->Form->control('id');
                    echo $this->Form->control('photo_order');
                    echo $this->Form->control('photo_frame_range');
                    echo $this->Form->control('photo_sent', ['type' => 'date']);
                    echo $this->Form->control('admin_notes');
                    echo '</tab>';
                }
            ?>


        </tabs>

<?php
echo $this->Form->button(__('Save Registration'), [
    'class' => 'btn btn-primary'
]);
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\'',
    'class' => 'btn btn-secondary'
));
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


<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>

<script type="text/javascript">

    var awards=<?php echo json_encode($awardinfo); ?>;
    var milestones=<?php echo json_encode($milestoneinfo); ?>;
    var regions=<?php echo json_encode($regions); ?>;
    var allCharities=<?php echo json_encode($charities); ?>;
    var donation=<?php echo json_encode($donation); ?>;

    Vue.component('tabs', {
        template: `
        <div>
            <div class="tabs">
              <ul class="nav">
                <li class="nav-item" v-for="tab in tabs" :class="{ 'is-active': tab.isActive }">
                    <a :href="tab.href" @click="selectTab(tab)">{{ tab.name }}</a>
                </li>
              </ul>
            </div>

            <div class="tabs-details">
                <slot></slot>
            </div>
        </div>
    `,

        data() {
            return {tabs: [] };
        },

        created() {

            this.tabs = this.$children;

        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == selectedTab.name);
                });
            }
        }
    });

    Vue.component('tab', {

        template: `

        <div v-show="isActive"><slot></slot></div>

    `,

        props: {
            name: { required: true },
            selected: { default: false}
        },

        data() {

            return {
                isActive: false
            };

        },

        computed: {

            href() {
                return '#' + this.name.toLowerCase().replace(/ /g, '-');
            }
        },

        mounted() {

            this.isActive = this.selected;

        }
    });

    new Vue({
        el: '#app',

        data: {
            currentAwards: [],
            currentAwardIndex: 0,
            milestone: 0,


            showPecsfDonation: true,
            showPecsfCharity1: true,
            showPecsfCharity2: true,
        },

        mounted() {

            // if donation
            this.showPecsfDonation = document.getElementById('pecsf-donation').checked;

            // if region selected, set up charities


            this.currentAwards = [];
            this.currentAwards.push(donation);

            sel = document.getElementById("milestone-id");
            currMilestone = sel.options[sel.selectedIndex].value;
            sel = document.getElementById("award-id");
            currAward = sel.options[sel.selectedIndex].value;
            this.setAwardOptions(currMilestone, currAward);
        },


        methods: {

            setAwardOptions: function (milestone, award) {

                for (var i = 0; i < awards.length; i++) {
                    if (awards[i].milestone_id == currMilestone) {
                        this.currentAwards.push(awards[i]);
                    }
                }

                var $el = $("#award-id");
                $el.empty(); // remove old options
                $.each(this.currentAwards, function(key,value) {
                    $el.append($("<option></option>")
                        .attr("value", value.id).text(value.name));
                });
                $("#award-id").val(currAward);
            }
        }

    });




    //var clrError = "#ff0000";
    //var clrDefault = "#d1d1d1";
    //
    //var awards=<?php //echo json_encode($awardinfo); ?>//;
    //var milestones=<?php //echo json_encode($milestoneinfo); ?>//;
    //var regions=<?php //echo json_encode($regions); ?>//;
    //var allCharities=<?php //echo json_encode($charities); ?>//;
    //
    //// $(function () {
    ////    $('#datetimepicker1').datetimepicker({format: 'L'});
    //// });
    //
    //function selectAward(award_id) {
    //    // store award id in hidden field so it gets saved on submit
    //    $('input[name=award_id]').val(award_id);
    //
    //    award = app.getAward(award_id);
    //
    //    $('#lsa-award-'+ app.selectedAward).css('background-color', 'transparent');
    //    // check if it is a donation
    //    if (award == 0) {
    //        app.awardName = "Charitiable Donation";
    //        app.awardDescription = "Donate $### to PECSF.";
    //        app.awardImage = '25_pecsf.jpg';
    //        $('#lsa-award-0').css('background-color', 'lightblue');
    //        app.selectCharityOptions();
    //    }
    //    else {
    //        app.awardName = award.name;
    //        app.awardDescription = award.description;
    //        app.awardImage = award.image;
    //        $('#lsa-award-'+award_id).css('background-color', 'lightblue');
    //        app.selectAwardOptions(award_id);
    //    }
    //    app.awardSelected = true;
    //}
    //
    //Vue.config.devtools = true;
    //
    //
    //var app = new Vue({
    //    el: "#app",
    //    data: {
    //        isRetiringThisYear: false,
    //        retirementStatusKnown: false,
    //        retirementDate: '',
    //        yearsOfService: 0,
    //        milestoneKnown: false,
    //        milestone: '',
    //
    //        employeeID: '',
    //        firstName: '',
    //        lastName: '',
    //        ministry: '',
    //        ministryBranch: '',
    //
    //        govtEmail: '',
    //        altEmail: '',
    //
    //        officeMailPrefix: '',
    //        officeSuite: '',
    //        officeStreetAddress: '',
    //        officeCity: '',
    //        officePostalCode: '',
    //        officePhone: '',
    //        officeExtension: '',
    //
    //        homeSuite: '',
    //        homeStreetAddress: '',
    //        homeCity: '',
    //        homePostalCode: '',
    //        homePhone: '',
    //
    //        supervisorFirstName: '',
    //        supervisorLastName: '',
    //        supervisorMailPrefix: '',
    //        supervisorSuite: '',
    //        supervisorStreetAddress: '',
    //        supervisorCity: '',
    //        supervisorPostalCode: '',
    //        supervisorEmail: '',
    //
    //        availableAwards: '',
    //        availableAwardOptions: '[display available options]',
    //
    //        currentAwardName: 'PECSF Donation',
    //        currentAwardImage: '25_pecsf.jpg',
    //        currentAwardDescription: 'description',
    //        currentAwardIndex: 0,
    //        currentAwards: [],
    //
    //        selectedAward: -1,
    //        awardName: '',
    //        awardDescription: '',
    //        awardOptions: [],
    //        awardImage: 'Watches-group-thumb.png',
    //
    //        availableCharities: [],
    //        donationRegion: '',
    //        donationCharity1: '',
    //        donationCharity2: '',
    //
    //        errorsEmployee: '',
    //        errorsOffice: '',
    //        errorsHome: '',
    //        errorsSupervisor: '',
    //        errorsOptions: '',
    //
    //        selectAward: false,
    //        awardSelected: false,
    //        awardConfirmed: false,
    //        identifyingInfoInput: false,
    //        officeAddressInput: false,
    //        homeAddressInput: false,
    //        supervisorInput: false,
    //        informationConfirmed: false,
    //        showOptions: true,
    //
    //        inputDonationType: false,
    //        inputCharity1: false,
    //        inputCharity2: false,
    //        testShow: false
    //    },
    //
    //    methods: {
    //
    //        getAward: function (select_id) {
    //            award = 0;
    //            for (var i = 0; i < awards.length; i++) {
    //                if (awards[i].id == select_id) {
    //                    award = awards[i];
    //                }
    //            }
    //            return award;
    //        },
    //
    //        getCharity: function (select_id) {
    //            charity = 0;
    //            for (var i = 0; i < allCharities.length; i++) {
    //                if (allCharities[i].id == select_id) {
    //                    charity = allCharities[i];
    //                }
    //            }
    //            return charity;
    //        },
    //
    //        selectCharityOptions: function () {
    //            $("#donation-1").modal('show');
    //            this.selectedAward = 0;
    //        },
    //
    //        regionSelected: function () {
    //            this.donationRegion = $('#selectedregion :selected').text();
    //
    //            this.availableCharities = [];
    //            for (var i = 0; i < allCharities.length; i++) {
    //                if (allCharities[i].pecsf_region_id == $('#selectedregion').val()) {
    //                    this.availableCharities.push(allCharities[i]);
    //                }
    //            }
    //            this.inputDonationType = true;
    //        },
    //
    //        donationTypeSelected: function() {
    //            if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
    //                this.inputCharity1 = false;
    //                this.inputCharity2 = false;
    //            }
    //            else if ($("input:radio[name ='selectDonationType']:checked").val() == 1) {
    //                this.inputCharity1 = true;
    //                this.inputCharity2 = false;
    //            }
    //            else if ($("input:radio[name ='selectDonationType']:checked").val() == 2) {
    //                this.inputCharity1 = true;
    //                this.inputCharity2 = true;
    //            }
    //        },
    //
    //        selectAwardOptions: function (select_id) {
    //            award = this.getAward(select_id);
    //
    //            options = JSON.parse(award.options);
    //            if (options.length > 0) {
    //                if (this.selectedAward != award.id) {
    //                    jQuery('#formAwardOptions').empty();
    //
    //                    availableOptions = "";
    //                    options.forEach((element, index, array) => {
    //                        availableOptions += "<p>" + element.name + "</p>";
    //                        if (element.type == "choice") {
    //                            input = '<label for="award-option-' + index + '">' + element.name + '</label>';
    //                            input += '<select id="award-option-' + index + '" requires="required">';
    //                            input += '<option value>- select option -</option>';
    //
    //                            for (var i = 0; i < element.values.length; i++) {
    //                                optionValue = element.values[i];
    //                                input += '<option value="' + i + '">' + element.values[i] + '</option>';
    //                            }
    //
    //                            input += '</select>';
    //                            jQuery('#formAwardOptions').append(input);
    //                        }
    //                        if (element.type == "text") {
    //                            input = '<label for="award-option-' + index + '">' + element.name + '</label>';
    //                            input += '<input type="text" id="award-option-' + index + '">';
    //                            jQuery('#formAwardOptions').append(input);
    //                        }
    //                    });
    //                }
    //                $("#awardName").html(award.name);
    //                $("#award-1").modal('show');
    //            }
    //            this.selectedAward = award.id;
    //        },
    //
    //        processOptions: function () {
    //            if (this.selectedAward == 0) {
    //                this.processDonationOptions();
    //            }
    //            else {
    //                this.processAwardOptions();
    //            }
    //        },
    //
    //        processDonationOptions: function() {
    //
    //            for (var i = 0; i < milestones.length; i++) {
    //                if (milestones[i].id == $('#milestone-id').val()) {
    //                    milestone = milestones[i];
    //                }
    //            }
    //
    //            errors = [];
    //
    //            $('input[name=pecsf_donation]').val(1);
    //
    //            this.awardOptions = [];
    //            $('#donation-type').css("border-color", clrDefault);
    //            if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
    //                amount = milestone.donation;
    //                this.awardOptions.push(this.currencyFormat(amount) + " Donation - PECSF Region Charity Fund");
    //                $('input[name=pecsf_amount1]').val(amount);
    //            }
    //            else if ($("input:radio[name ='selectDonationType']:checked").val() == 1) {
    //                if ($('#selectedCharity1').val() == 0) {
    //                    errors.push("Charity is required");
    //                    $('#selectedCharity1').css("border-color", clrError);
    //                }
    //                else {
    //                    amount = milestone.donation;
    //                    charity = this.getCharity($('#selectedCharity1').val());
    //                    this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") " + charity.name);
    //                    $('#selectedCharity1').css("border-color", clrDefault);
    //
    //                    $('input[name=pecsf_charity1_id]').val(charity.id);
    //                    $('input[name=pecsf_amount1]').val(amount);
    //                }
    //
    //            }
    //            else if ($("input:radio[name ='selectDonationType']:checked").val() == 2) {
    //                amount = milestone.donation / 2;
    //
    //                if ($('#selectedCharity1').val() == 0) {
    //                    errors.push("First Charity is required");
    //                    $('#selectedCharity1').css("border-color", clrError);
    //                }
    //                else {
    //                    charity = this.getCharity($('#selectedCharity1').val());
    //                    this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") "  + charity.name);
    //                    $('#selectedCharity1').css("border-color", clrDefault);
    //                    $('input[name=pecsf_charity1_id]').val(charity.id);
    //                    $('input[name=pecsf_amount1]').val(amount);
    //                }
    //
    //                if ($('#selectedCharity2').val() == 0) {
    //                    errors.push("Second Charity is required");
    //                    $('#selectedCharity2').css("border-color", clrError);
    //                }
    //                else {
    //                    charity = this.getCharity($('#selectedCharity2').val());
    //                    this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") "  + charity.name);
    //                    $('#selectedCharity2').css("border-color", clrDefault);
    //                    $('input[name=pecsf_second_charity]').val(1);
    //                    $('input[name=pecsf_charity2_id]').val(charity.id);
    //                    $('input[name=pecsf_amount2]').val(amount);
    //                }
    //            }
    //            else {
    //                if (this.inputDonationType) {
    //                    errors.push('Please select the type of donation.');
    //                    $('#donation-type').css("border-color", clrError);
    //                }
    //            }
    //
    //            if (document.getElementById("selectedregion").selectedIndex == 0) {
    //                errors.push('Region is required');
    //                $('#selectedregion').css("border-color", clrError);
    //            }
    //            else {
    //                $('#selectedregion').css("border-color", clrDefault);
    //                $('input[name=pecsf_region_id]').val(document.getElementById("selectedregion").selectedIndex);
    //            }
    //
    //            if (errors.length == 0) {
    //                $('input[name=award_options]').val(JSON.stringify(this.awardOptions));
    //                $("#donation-1").modal('hide');
    //                this.errorsOptions = '';
    //            }
    //            else {
    //                this.errorsOptions = '<ul>';
    //                for (var i = 0; i < errors.length; i++) {
    //                    this.errorsOptions += '<li>' + errors[i] + '</li>';
    //                }
    //                this.errorsOptions += '</ul>';
    //            }
    //
    //        },
    //
    //
    //        processAwardOptions: function () {
    //            award = this.getAward(this.selectedAward);
    //            options = JSON.parse(award.options);
    //
    //            errors = [];
    //
    //            this.awardOptions = [];
    //            for (i = 0; i < options.length; i++) {
    //                if (options[i].type == "choice") {
    //                    var sel = document.getElementById("award-option-"+i);
    //                    if (sel.selectedIndex == 0) {
    //                        errors.push(options[i].name + " is required");
    //                    }
    //                    else {
    //                        this.awardOptions.push(options[i].name + ": " + sel.options[sel.selectedIndex].text);
    //                    }
    //                }
    //                if (options[i].type == "text") {
    //                    var field = document.getElementById("award-option-"+i);
    //                    if (field.value) {
    //                        this.awardOptions.push(options[i].name + ": " + field.value);
    //                    }
    //                    else {
    //                        errors.push(options[i].name + " is required");
    //                    }
    //                }
    //            }
    //
    //            if (errors.length == 0) {
    //                $('input[name=award_options]').val(JSON.stringify(this.awardOptions));
    //                $("#award-1").modal('hide');
    //                this.errorsOptions = '';
    //
    //                // Reset PECSF Donation values in case user previous selected PECSF donation option
    //                $('input[name=pecsf_region_id]').val(0);
    //                $('input[name=pecsf_donation]').val(0);
    //                $('input[name=pecsf_charity1_id]').val(0);
    //                $('input[name=pecsf_amount1]').val(0);
    //                $('input[name=pecsf_second_charity]').val(0);
    //                $('input[name=pecsf_charity2_id]').val(0);
    //                $('input[name=pecsf_amount2]').val(0);
    //            }
    //            else {
    //                this.errorsOptions = '<ul>';
    //                for (var i = 0; i < errors.length; i++) {
    //                    this.errorsOptions += '<li>' + errors[i] + '</li>';
    //                }
    //                this.errorsOptions += '</ul>';
    //            }
    //        },
    //
    //        milestoneSelected: function (milestone) {
    //            this.exposeAwardSelector(milestone);
    //
    //            var sel = document.getElementById("milestone-id");
    //            this.milestone = sel.options[sel.selectedIndex].text;
    //
    //            this.currentAwards = [];
    //            var donation = {
    //                id: 0,
    //                name: "PECSF Donation",
    //                description: "Instead of choosing an award from the catalogue, you can opt to make a charitable donation via the Provincial Employees Community Services Fund. A framed certificate of service, signed by the Premier of British Columbia, will be presented to you noting your charitable contribution.",
    //                image: "25_pecsf.jpg"
    //            };
    //
    //            this.currentAwards.push(donation);
    //
    //            for (var i = 0; i < awards.length; i++) {
    //                if (awards[i].milestone_id == milestone) {
    //                    this.currentAwards.push(awards[i]);
    //                }
    //            }
    //
    //            this.currentAwardIndex = 0;
    //            this.updateAwardDisplay(this.currentAwardIndex);
    //
    //            // this.availableAwards = awardDisplay;
    //        },
    //
    //        showPreviousAward: function() {
    //            this.currentAwardIndex--;
    //            if (this.currentAwardIndex < 0) {
    //                this.currentAwardIndex = this.currentAwards.length - 1;
    //            }
    //            this.updateAwardDisplay(this.currentAwardIndex);
    //        },
    //
    //        showNextAward: function() {
    //            this.currentAwardIndex++;
    //            if (this.currentAwardIndex >= this.currentAwards.length) {
    //                this.currentAwardIndex = 0;
    //            }
    //            this.updateAwardDisplay(this.currentAwardIndex);
    //        },
    //
    //        updateAwardDisplay: function(awardIndex) {
    //            this.currentAwardName = this.currentAwards[awardIndex].name;
    //            this.currentAwardImage = this.currentAwards[awardIndex].image;
    //            this.currentAwardDescription = this.currentAwards[awardIndex].description;
    //            if (this.selectedAward == this.currentAwards[awardIndex].id) {
    //                $('#lsa-award-card').css('background-color', 'lightblue');
    //            }
    //            else {
    //                $('#lsa-award-card').css('background-color', 'transparent');
    //            }
    //        },
    //
    //
    //        selectCurrentAward: function() {
    //
    //            award = this.currentAwards[this.currentAwardIndex];
    //
    //            // store award id in hidden field so it gets saved on submit
    //            $('input[name=award_id]').val(award.id);
    //
    //            // $('#lsa-award-'+ app.selectedAward).css('background-color', 'transparent');
    //            $('#lsa-award-card').css('background-color', 'lightblue');
    //            app.awardName = award.name;
    //            app.awardDescription = award.description;
    //            app.awardImage = award.image;
    //
    //            // check if it is a donation
    //            if (award.id == 0) {
    //                app.selectCharityOptions();
    //            }
    //            else {
    //                app.selectAwardOptions(award.id);
    //            }
    //
    //            this.selectedAward = award.id;
    //
    //            app.awardConfirmed = true;
    //            $('html, body').animate({
    //                scrollTop: $("#employeeAnchor").offset().top
    //            }, 1000);
    //        },
    //
    //        officeCitySelected: function () {
    //            var sel = document.getElementById("office-city-id");
    //            if (sel.selectedIndex > 0) {
    //                this.officeCity = sel.options[sel.selectedIndex].text;
    //            }
    //            else {
    //                this.officeCity = '';
    //            }
    //
    //        },
    //
    //        homeCitySelected: function () {
    //            var sel = document.getElementById("home-city-id");
    //            if (sel.selectedIndex > 0) {
    //                this.homeCity = sel.options[sel.selectedIndex].text;
    //            }
    //            else {
    //                this.homeCity = '';
    //            }
    //        },
    //
    //        supervisorCitySelected: function () {
    //            var sel = document.getElementById("supervisor-city-id");
    //            if (sel.selectedIndex > 0) {
    //                this.supervisorCity = sel.options[sel.selectedIndex].text;
    //            }
    //            else {
    //                this.supervisorCity = '';
    //            }
    //        },
    //
    //        ministrySelected: function () {
    //            var sel = document.getElementById("ministry-id");
    //            if (sel.selectedIndex > 0) {
    //                this.ministry = sel.options[sel.selectedIndex].text;
    //            }
    //            else {
    //                this.ministry = '';
    //            }
    //        },
    //
    //        buttonMissedCeremony: function (missed) {
    //            if (missed == 1) {
    //                this.selectAward = false;
    //                this.showIdentifyingInfoInputs();
    //            }
    //            else {
    //                this.selectAward = true;
    //            }
    //        },
    //
    //        buttonRetirementClick: function (retiring) {
    //            $('input[name=retiring_this_year]').val(retiring);
    //            if (retiring == 1) {
    //                this.exposeRetirementDatePicker();
    //            }
    //            else {
    //                this.setRetirementStatusKnown();
    //            }
    //            $('html, body').animate({
    //                scrollTop: $("#employeeAnchor").offset().top
    //            }, 1000);
    //        },
    //
    //        exposeRetirementDatePicker: function () {
    //            this.isRetiringThisYear = true;
    //            this.retirementStatusKnown = true;
    //        },
    //
    //        setRetirementStatusKnown: function () {
    //            this.isRetiringThisYear = false;
    //            this.retirementStatusKnown = true;
    //        },
    //
    //        exposeAwardSelector: function(milestone) {
    //            this.milestoneKnown = true;
    //        },
    //
    //        showIdentifyingInfoInputs: function () {
    //            this.awardConfirmed = true;
    //        },
    //
    //        showOfficeAddressInput: function () {
    //
    //            errors = this.checkIdentifyingInfo();
    //            if (errors.length == 0) {
    //                $('html, body').animate({
    //                    scrollTop: $("#officeAnchor").offset().top
    //                }, 1000);
    //
    //                this.identifyingInfoInput = true;
    //                this.errorsEmployee = '';
    //            }
    //            else {
    //
    //                this.errorsEmployee = '<ul>';
    //                for (var i = 0; i < errors.length; i++) {
    //                    this.errorsEmployee += '<li>' + errors[i] + '</li>';
    //                }
    //                this.errorsEmployee += '</ul>';
    //            }
    //        },
    //
    //        showHomeAddressInput: function () {
    //
    //            errors = this.checkOfficeAddressInput();
    //            if (errors.length == 0) {
    //                $('html, body').animate({
    //                    scrollTop: $("#homeAnchor").offset().top
    //                }, 1000);
    //                this.officeAddressInput = true;
    //                this.errorsOffice = '';
    //            }
    //            else {
    //                this.errorsOffice = '<ul>';
    //                for (var i = 0; i < errors.length; i++) {
    //                    this.errorsOffice += '<li>' + errors[i] + '</li>';
    //                }
    //                this.errorsOffice += '</ul>';
    //            }
    //        },
    //
    //        showSupervisorInput: function () {
    //            errors = this.checkHomeAddressInput();
    //            if (errors.length == 0) {
    //                $('html, body').animate({
    //                    scrollTop: $("#supervisorAnchor").offset().top
    //                }, 1000);
    //                this.homeAddressInput = true;
    //                this.errorsHome = '';
    //            }
    //            else {
    //                this.errorsHome = '<ul>';
    //                for (var i = 0; i < errors.length; i++) {
    //                    this.errorsHome += '<li>' + errors[i] + '</li>';
    //                }
    //                this.errorsHome += '</ul>';
    //            }
    //        },
    //
    //        showConfirmation: function () {
    //            errors = this.checkSupervisorInput();
    //            if (errors.length == 0) {
    //                $('html, body').animate({
    //                    scrollTop: $("#confirmationAnchor").offset().top
    //                }, 1000);
    //                this.supervisorInput = true;
    //                this.errorsSupervisor = '';
    //            }
    //            else {
    //                this.errorsSupervisor = '<ul>';
    //                for (var i = 0; i < errors.length; i++) {
    //                    this.errorsSupervisor += '<li>' + errors[i] + '</li>';
    //                }
    //                this.errorsSupervisor += '</ul>';
    //            }
    //        },
    //
    //        showDeclaration: function () {
    //            this.informationConfirmed = true;
    //            $('html, body').animate({
    //                scrollTop: $("#declarationAnchor").offset().top
    //            }, 1000);
    //        },
    //
    //        currencyFormat: function (num) {
    //            return '$' + parseFloat(num).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    //        },
    //
    //        checkIdentifyingInfo: function () {
    //
    //            var error = [];
    //
    //            if (!this.employeeID) {
    //                $('#employee-id').css("border-color", clrError);
    //                error.push('Employee ID is required');
    //            }
    //            else {
    //                $('#employee-id').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.firstName) {
    //                $('#first-name').css("border-color", clrError);
    //                error.push('Employee first name is required');
    //            }
    //            else {
    //                $('#first-name').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.lastName) {
    //                $('#last-name').css("border-color", clrError);
    //                error.push('Employee last name is required');
    //            }
    //            else {
    //                $('#last-name').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.ministry) {
    //                $('#ministry-id').css("border-color", clrError);
    //                error.push('Ministry is required');
    //            }
    //            else {
    //                $('#ministry-id').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.ministryBranch) {
    //                $('#department').css("border-color", clrError);
    //                error.push('Branch is required');
    //            }
    //            else {
    //                $('#department').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.govtEmail) {
    //                $('#preferred-email').css("border-color", clrError);
    //                error.push('Government Email is required.');
    //            }
    //            else {
    //                if (!isEmail(this.govtEmail)) {
    //                    $('#preferred-email').css("border-color", clrError);
    //                    error.push('Government Email invalid format');
    //                }
    //                else {
    //                    $('#preferred-email').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            if (this.altEmail) {
    //                if (!isEmail(this.altEmail)) {
    //                    $('#alternate-email').css("border-color", clrError);
    //                    error.push('Alternate Email invalid format');
    //                } else {
    //                    $('#alternate-email').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            return error;
    //        },
    //
    //        checkOfficeAddressInput: function () {
    //
    //            var error = [];
    //
    //            if (!this.officeStreetAddress) {
    //                $('#office-address').css("border-color", clrError);
    //                error.push('Office Address is required');
    //            }
    //            else {
    //                $('#office-address').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.officeCity) {
    //                $('#office-city-id').css("border-color", clrError);
    //                error.push ('Office City is required');
    //            }
    //            else {
    //                $('#office-city-id').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.officePostalCode) {
    //                $('#office-postal-code').css("border-color", clrError);
    //                error.push ('Office Postal Code is required');
    //            }
    //            else {
    //                if (!isPostalCode(this.officePostalCode)) {
    //                    $('#office-postal-code').css("border-color", clrError);
    //                    error.push ('Office Postal Code invalid format (A1A 1A1)');
    //                }
    //                else {
    //                    $('#office-postal-code').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            if (!this.officePhone) {
    //                $('#work-phone').css("border-color", clrError);
    //                error.push ('Office Phone number is required');
    //            }
    //            else {
    //                if (!isPhone(this.officePhone)) {
    //                    $('#work-phone').css("border-color", clrError);
    //                    error.push ('Office Phone number invalid format (###) ###-####');
    //                }
    //                else {
    //                    $('#work-phone').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            return error;
    //        },
    //
    //        checkHomeAddressInput: function () {
    //
    //            var error = [];
    //
    //            if (!this.homeStreetAddress) {
    //                $('#home-address').css("border-color", clrError);
    //                error.push('Home Address is required');
    //            }
    //            else {
    //                $('#home-address').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.homeCity) {
    //                $('#home-city-id').css("border-color", clrError);
    //                error.push('Home City is required');
    //            }
    //            else {
    //                $('#home-city-id').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.homePostalCode) {
    //                $('#home-postal-code').css("border-color", clrError);
    //                error.push('Home Postal Code is required');
    //            }
    //            else {
    //                if (!isPostalCode(this.homePostalCode)) {
    //                    $('#home-postal-code').css("border-color", clrError);
    //                    error.push('Home Postal Code invalid format (A1A 1A1)');
    //                }
    //                else {
    //                    $('#home-postal-code').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            if (!this.homePhone) {
    //                $('#home-phone').css("border-color", clrError);
    //                error.push('Home Phone number is required');
    //            }
    //            else {
    //                if (!isPhone(this.homePhone)) {
    //                    $('#home-phone').css("border-color", clrError);
    //                    error.push('Home Phone number invalid format (###) ###-####');
    //                }
    //                else {
    //                    $('#home-phone').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            return error;
    //        },
    //
    //
    //        checkSupervisorInput: function () {
    //
    //            var error = [];
    //
    //            if (!this.supervisorFirstName) {
    //                $('#supervisor-first-name').css("border-color", clrError);
    //                error.push('Supervisor First Name is required');
    //            }
    //            else {
    //                $('#supervisor-first-name').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.supervisorLastName) {
    //                $('#supervisor-last-name').css("border-color", clrError);
    //                error.push('Supervisor last name is required');
    //            }
    //            else {
    //                $('#supervisor-last-name').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.supervisorStreetAddress) {
    //                $('#supervisor-address').css("border-color", clrError);
    //                error.push('Supervisor Address is required');
    //            }
    //            else {
    //                $('#supervisor-address').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.supervisorCity) {
    //                $('#supervisor-city-id').css("border-color", clrError);
    //                error.push('Supervisor City is required');
    //            }
    //            else {
    //                $('#supervisor-city-id').css("border-color", clrDefault);
    //            }
    //
    //            if (!this.supervisorPostalCode) {
    //                $('#supervisor-postal-code').css("border-color", clrError);
    //                error.push('Supervisor Postal Code is required');
    //            }
    //            else {
    //                if (!isPostalCode(this.supervisorPostalCode)) {
    //                    $('#supervisor-postal-code').css("border-color", clrError);
    //                    error.push('Supervisor Postal Code invalid format (A1A 1A1)');
    //                }
    //                else {
    //                    $('#supervisor-postal-code').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            if (!this.supervisorEmail) {
    //                $('#supervisor-email').css("border-color", clrError);
    //                error.push('Supervisor Email is required');
    //            }
    //            else {
    //                if (!isEmail(this.supervisorEmail)) {
    //                    $('#supervisor-email').css("border-color", clrError);
    //                    error.push('Supervisor Email invalid format');
    //                }
    //                else {
    //                    $('#supervisor-email').css("border-color", clrDefault);
    //                }
    //            }
    //
    //            return error;
    //        },
    //
    //    }
    //});
    //
    //
    //
    //function isEmail (email) {
    //    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    //    return regex.test(email);
    //}
    //
    //function isPhone (phone) {
    //    var regex = /\(([0-9]{3})\) ([0-9]{3})-([0-9]{4})/;
    //    return regex.test(phone);
    //}
    //
    //function isPostalCode (code) {
    //    var regex = /^[ABCEGHJ-NPRSTVXY][0-9][ABCEGHJ-NPRSTV-Z] [0-9][ABCEGHJ-NPRSTV-Z][0-9]$/;
    //    return regex.test(code);
    //}
    //
    //var scroll = new SmoothScroll('a[href*="#"]', {
    //    speed: 1500
    //});

</script>
