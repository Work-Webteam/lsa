<div class="container" id="app">
    <h1><?= $registration->first_name . " " . $registration->last_name ?></h1>

    <?php
    echo $this->Form->create($registration, ['@submit' => 'processForm', 'horizontal' => true]);

    echo $this->Form->hidden('award_options', ['value' => '']);
    echo $this->Form->hidden('pecsf_donation', ['v-model' => 'pecsfDonation']);
    echo $this->Form->hidden('pecsf_donation_type', ['v-model' => 'pecsfDonationType']);
    echo $this->Form->hidden('pecsf_region_id', ['v-model' => 'pecsfRegion']);
    echo $this->Form->hidden('pecsf_charity1_id', ['v-model' => 'pecsfCharityId1']);
    echo $this->Form->hidden('pecsf_amount1', ['v-model' => 'pecsfAmount1']);
    echo $this->Form->hidden('pecsf_charity2_id', ['v-model' => 'pecsfCharityId2']);
    echo $this->Form->hidden('pecsf_amount2', ['v-model' => 'pecsfAmount2']);
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
        echo $this->Form->control('alternate_email');
        echo '</tab>';
        ?>

        <?php
        echo '<tab name="Award">';

        echo $this->Form->control('milestone_id', ['options' => $milestones, 'v-model' => 'selectedMilestone', 'onChange' => 'app.milestoneChanged(this.value)']);
        echo $this->Form->hidden('award_id', ['value' => 0, 'v-model' => 'selectedAward']);
        //                echo $this->Form->control('award_id', ['options' => $awards]);
        ?>

        <div id="lsa-award-card">
            <img alt="..." v-bind:src="'/img/awards/' + currentAwardImage" class="lsa-award-image">
            <div class="card-body">
                <h5 class="card-title">{{ currentAwardName }}</h5>
                <p class="card-text">{{ currentAwardDescription }}</p>
            </div>
        </div>
        <div>
            <?php
            echo $this->Form->button('<', ['type' => 'button', 'onclick' => 'app.showPreviousAward()', 'class' => 'btn btn-primary']);
            echo "&nbsp;";
            echo $this->Form->button('Select Award', ['type' => 'button', 'onclick' => 'app.selectCurrentAward()', 'class' => 'btn btn-primary']);
            echo "&nbsp;";
            echo $this->Form->button('>', ['type' => 'button',  'onclick' => 'app.showNextAward()', 'class' => 'btn btn-primary']);
            ?>
            <!--                <button onClick="app.showPreviousAward"> < </button><button>Select</button><button v-on:click="showNextAward"> > </button>-->
        </div>

        <?php

        if ($isadmin) {
            echo $this->Form->control('award_year', ['label' => 'Award Year']);
            echo $this->Form->control('award_received', ['type' => 'checkbox']);
            echo $this->Form->control('engraving_sent', ['type' => 'checkbox']);
            echo $this->Form->control('certificate_name');
            echo $this->Form->control('certificate_ordered');
            echo $this->Form->control('award_instructions', ['label' => 'Award Instructions', 'type' => 'textarea']);

            echo '<div v-if="pecsfDonation">';
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
        echo $this->Form->control('office_province', ['label' => 'Province','disabled' => true]);
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
        echo $this->Form->control('home_province', ['label' => 'Province','disabled' => true]);
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
        echo $this->Form->control('supervisor_province', ['label' => 'Province','disabled' => true]);
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

    <div id="lsa-edit-errors">
        <span v-html="errorsOptions" class="lsa-errors-container">
        </span>
    </div>
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
                            <select id="selectedCharity1" v-model="selectedCharity1">
                                <option value>- select charity -</option>
                                <option v-for='data in availableCharities' :value='data.id'>{{ data.name }}</option>
                            </select>
                        </div>
                        <div v-if="inputCharity2">
                            <select id="selectedCharity2" v-model="selectedCharity2">
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
    var donation=<?php echo json_encode($donation); ?>;
    var options=<?php echo $registration->award_options; ?>;

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

    var app = new Vue({
        el: '#app',

        data: {
            originalAward: <?php echo $registration->award_id; ?>,
            selectedMilestone: <?php echo $registration->milestone_id; ?>,
            selectedAward: <?php echo $registration->award_id; ?>,
            selectedRegion: <?php echo $registration->pecsf_region_id ? $registration->pecsf_region_id : 0; ?>,
            selectedCharity1: <?php echo $registration->pecsf_charity1_id ? $registration->pecsf_charity1_id : 0; ?>,
            selectedCharity2: <?php echo $registration->pecsf_charity2_id ? $registration->pecsf_charity2_id : 0; ?>,
            selectedOptions: [],

            pecsfDonation: <?php echo $registration->pecsf_donation ? 1 : 0; ?>,
            pecsfDonationType: <?php echo $registration->pecsf_donation_type ? $registration->pecsf_donation_type : 0; ?>,
            pecsfRegion: <?php echo $registration->pecsf_region_id ? $registration->pecsf_region_id : 0; ?>,
            pecsfCharity1: <?php echo $registration->pecsf_first_charity ? 1 : 0; ?>,
            pecsfCharityId1: <?php echo $registration->pecsf_charity1_id ? $registration->pecsf_charity1_id : 0; ?>,
            pecsfAmount1: <?php echo $registration->pecsf_amount1; ?>,
            pecsfCharity2:  <?php echo $registration->pecsf_second_charity ? 1 : 0; ?>,
            pecsfCharityId2: <?php echo $registration->pecsf_charity2_id ? $registration->pecsf_charity2_id : 0; ?>,
            pecsfAmount2: <?php echo $registration->pecsf_amount2; ?>,

            currentAwards: [],
            currentAwardIndex: 0,
            currentAwardImage: "",
            currentAwardName: "",
            currentAwardDescription: "",
            currentAwardOptions: [],


            inputDonationType: true,
            inputCharity1: true,
            inputCharity2: true,

            availableCharities: [],
            donationRegion: '',
            donationCharity1: '',
            donationCharity2: '',

            errorsOptions: '',

        },

        mounted() {

            this.setAvailableAwards();
            this.updateAwardDisplay(this.currentAwardIndex);
            this.selectedOptions = this.parseSelectedOptions(options);
            $('input[name=award_options]').val(JSON.stringify(options));
        },


        methods: {

            processForm: function(e) {
                console.log('processForm');

                // error checking goes here
                // 1. check an award has been selected
                errors = [];
                errors = errors.concat(this.checkEmployeeInfo());
                errors = errors.concat(this.checkOfficeAddress());
                errors = errors.concat(this.checkHomeAddress());
                errors = errors.concat(this.checkSupervisor());
console.log(errors);

                if (errors.length > 0) {
                    this.errorsOptions = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsOptions += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsOptions += '</ul>';
                    e.preventDefault();
                }
                else {
                    this.errorsOptions = '';
                }

                if (this.selectedAward !== this.originalAward) {
                    if (this.selectedAward !== 0) {
                        this.pecsfDonation = 0;
                        this.pecsfDonationType = null;
                        this.pecsfRegion = 0;
                        this.pecsfCharity1 = 0;
                        this.pecsfCharityId1 = 0;
                        this.pecsfAmount1 = 0;
                        this.pecsfCharity2 = 0;
                        this.pecsfCharityId2 = 0;
                        this.pecsfAmount2 = 0;
                    }
                }

            },

            getMilestone: function (id) {
                for (var i = 0; i < milestones.length; i++) {
                    if (milestones[i].id == id) {
                        milestone = milestones[i];
                    }
                }
                return milestone;
            },

            getAward: function (id) {
                for (var i = 0; i < awards.length; i++) {
                    if (awards[i].id == id) {
                        award = awards[i];
                    }
                }
                return award;
            },

            getCharity: function (id) {
                for (var i = 0; i < allCharities.length; i++) {
                    if (allCharities[i].id == id) {
                        charity = allCharities[i];
                    }
                }
                return charity;
            },

            setAvailableAwards: function () {

                this.currentAwards = [];
                this.currentAwards.push(donation);

                this.currentAwardIndex = 0
                for (var i = 0; i < awards.length; i++) {
                    if (awards[i].milestone_id == this.selectedMilestone) {
                        this.currentAwards.push(awards[i]);
                        if (awards[i].id == this.selectedAward) {
                            this.currentAwardIndex = this.currentAwards.length - 1;
                        }
                    }
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
                this.currentAwardDescription = this.currentAwards[awardIndex].description;
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

                $('#lsa-award-card').css('background-color', 'lightblue');

                // check if it is a donation
                if (award.id == 0) {
                    app.selectCharityOptions();
                }
                else {
                    app.selectAwardOptions(award.id);
                }

                this.selectedAward = award.id;

            },

            selectCharityOptions: function () {
                $("#donation-1").modal('show');

                this.inputDonationType = false;
                if (this.selectedRegion > 0) {
                    $("#selectedregion").val(this.selectedRegion);
                    this.inputDonationType = true;
                    $("#selectdonationtype-"+this.pecsfDonationType).prop("checked", true);
                    this.regionSelected();
                }

                this.inputCharity1 = this.selectedCharity1 > 0;
                this.inputCharity2 = this.selectedCharity2 > 0;
                this.selectedAward = 0;
            },

            selectAwardOptions: function (select_id) {
                award = this.getAward(select_id);
                options = JSON.parse(award.options);

                if (options.length > 0) {
                        jQuery('#formAwardOptions').empty();

                        availableOptions = "";
                        options.forEach((element, index, array) => {
                            availableOptions += "<p>" + element.name + "</p>";
                            if (element.type == "choice") {
                                selectedValue = this.getSelectedOption(element.name);

                                input = '<label for="award-option-' + index + '">' + element.name + '</label>';
                                input += '<select id="award-option-' + index + '" requires="required">';
                                input += '<option value>- select option -</option>';

                                for (var i = 0; i < element.values.length; i++) {
                                    sel = "";
                                    if (element.values[i] == selectedValue) {
                                        sel = "selected"
                                    }
                                    optionValue = element.values[i];
                                    input += '<option value="' + i + '" ' + sel + '>' + element.values[i] + '</option>';
                                }

                                input += '</select>';
                                jQuery('#formAwardOptions').append(input);
                            }
                            if (element.type == "text") {
                                optionText = this.getSelectedOption(element.name);
                                input = '<label for="award-option-' + index + '">' + element.name + '</label>';
                                input += '<input type="text" id="award-option-' + index + '" value="' + optionText + '">';
                                jQuery('#formAwardOptions').append(input);
                            }
                        });

                    $("#awardName").html(award.name);
                    $("#award-1").modal('show');
                }
                this.selectedAward = award.id;
            },

            getSelectedOption: function (key) {
                for (var i = 0; i < this.selectedOptions.length; i++) {
                    if (this.selectedOptions[i][0] == key) {
                        return this.selectedOptions[i][1];
                    }
                }
                return "";
            },

            parseSelectedOptions: function (selections) {
                var results = [];

                for (var i = 0; i < selections.length; i++) {
                    var res = this.split_str(selections[i], ': ', 2);
                    results.push(res);
                }
                return results;
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
                this.selectedRegion = $('#selectedregion').val();
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

                this.awardOptions = [];
                $('#donation-type').css("border-color", clrDefault);
                if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
                    amount = milestone.donation;
                    this.awardOptions.push(this.currencyFormat(amount) + " Donation - PECSF Region Charity Fund");
                    $('input[name=pecsf_amount1]').val(amount);
                    $('input[name=pecsf_charity1_id]').val(0);
                    $('input[name=pecsf_charity2_id]').val(0);
                    $('input[name=pecsf_amount2]').val(0);
                    $('input[name=pecsf_donation_type]').val(0);
                    this.pecsfDonationType = 0;
                    this.selectedCharity1 = 0;
                    this.selectedCharity2 = 0;
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
                        $('input[name=pecsf_donation_type]').val(1);
                        $('input[name=pecsf_charity1_id]').val(charity.id);
                        $('input[name=pecsf_amount1]').val(amount);
                        $('input[name=pecsf_charity2_id]').val(0);
                        $('input[name=pecsf_amount2]').val(0);
                        this.selectedCharity1 = charity.id;
                        this.selectedCharity2 = 0;
                        this.pecsfDonationType = 1;
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
                        $('input[name=pecsf_charity1_id]').val(charity.id);
                        $('input[name=pecsf_amount1]').val(amount);
                        this.selectedCharity1 = charity.id;
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
                        this.selectedCharity2 = charity.id;
                    }
                    $('input[name=pecsf_donation_type]').val(2);
                    this.pecsfDonationType = 2;
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
                    this.selectedOptions = this.parseSelectedOptions(this.awardOptions);
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

            milestoneChanged: function (milestone) {

                this.selectedMilestone = milestone;
                this.setAvailableAwards();
                this.currentAwardIndex = 0;
                this.selectedAward = null;
                this.updateAwardDisplay(this.currentAwardIndex);
            },


            checkEmployeeInfo: function () {

                var error = [];

                if ($('#employee-id').val().length == 0) {
                    $('#employee-id').css("border-color", clrError);
                    error.push('Employee ID is required');
                }
                else {
                    $('#employee-id').css("border-color", clrDefault);
                }

                if ($('#first-name').val().length == 0) {
                    $('#first-name').css("border-color", clrError);
                    error.push('Employee first name is required');
                }
                else {
                    $('#first-name').css("border-color", clrDefault);
                }

                if ($('#last-name').val().length == 0) {
                    $('#last-name').css("border-color", clrError);
                    error.push('Employee last name is required');
                }
                else {
                    $('#last-name').css("border-color", clrDefault);
                }

                if ($('#ministry-id').val().length == 0) {
                    $('#ministry-id').css("border-color", clrError);
                    error.push('Ministry is required');
                }
                else {
                    $('#ministry-id').css("border-color", clrDefault);
                }

                if ($('#branch').val().length == 0) {
                    $('#branch').css("border-color", clrError);
                    error.push('Branch is required');
                }
                else {
                    $('#branch').css("border-color", clrDefault);
                }

                if ($('#preferred-email').val().length == 0) {
                    $('#preferred-email').css("border-color", clrError);
                    error.push('Government Email is required.');
                }
                else {
                    if (!isEmail($('#preferred-email').val())) {
                        $('#preferred-email').css("border-color", clrError);
                        error.push('Government Email invalid format');
                    }
                    else {
                        $('#preferred-email').css("border-color", clrDefault);
                    }
                }

                if ($('#alternate-email').val().length > 0) {
                    if (!isEmail($('#alternate-email').val())) {
                        $('#alternate-email').css("border-color", clrError);
                        error.push('Alternate Email invalid format');
                    } else {
                        $('#alternate-email').css("border-color", clrDefault);
                    }
                }

                return error;
            },

            checkOfficeAddress: function () {

                var error = [];

                if ($('#office-address').val().length == 0) {
                    $('#office-address').css("border-color", clrError);
                    error.push('Office Address is required');
                }
                else {
                    $('#office-address').css("border-color", clrDefault);
                }

                if ($('#office-city-id').val().length == 0) {
                    $('#office-city-id').css("border-color", clrError);
                    error.push ('Office City is required');
                }
                else {
                    $('#office-city-id').css("border-color", clrDefault);
                }

                if ($('#office-postal-code').val().length == 0) {
                    $('#office-postal-code').css("border-color", clrError);
                    error.push ('Office Postal Code is required');
                }
                else {
                    if (!isPostalCode($('#office-postal-code').val())) {
                        $('#office-postal-code').css("border-color", clrError);
                        error.push ('Office Postal Code invalid format (A1A 1A1)');
                    }
                    else {
                        $('#office-postal-code').css("border-color", clrDefault);
                    }
                }

                if ($('#work-phone').val().length == 0) {
                    $('#work-phone').css("border-color", clrError);
                    error.push ('Office Phone number is required');
                }
                else {
                    if (!isPhone($('#work-phone').val())) {
                        $('#work-phone').css("border-color", clrError);
                        error.push ('Office Phone number invalid format (###) ###-####');
                    }
                    else {
                        $('#work-phone').css("border-color", clrDefault);
                    }
                }

                return error;
            },

            checkHomeAddress: function () {

                var error = [];

                if ($('#home-address').val().length == 0) {
                    $('#home-address').css("border-color", clrError);
                    error.push('Home Address is required');
                }
                else {
                    $('#home-address').css("border-color", clrDefault);
                }

                if ($('#home-city-id').val().length == 0) {
                    $('#home-city-id').css("border-color", clrError);
                    error.push('Home City is required');
                }
                else {
                    $('#home-city-id').css("border-color", clrDefault);
                }

                if ($('#home-postal-code').val().length == 0) {
                    $('#home-postal-code').css("border-color", clrError);
                    error.push('Home Postal Code is required');
                }
                else {
                    if (!isPostalCode($('#home-postal-code').val())) {
                        $('#home-postal-code').css("border-color", clrError);
                        error.push('Home Postal Code invalid format (A1A 1A1)');
                    }
                    else {
                        $('#home-postal-code').css("border-color", clrDefault);
                    }
                }

                if ($('#home-phone').val().length == 0) {
                    $('#home-phone').css("border-color", clrError);
                    error.push('Home Phone number is required');
                }
                else {
                    if (!isPhone($('#home-phone').val())) {
                        $('#home-phone').css("border-color", clrError);
                        error.push('Home Phone number invalid format (###) ###-####');
                    }
                    else {
                        $('#home-phone').css("border-color", clrDefault);
                    }
                }

                return error;
            },


            checkSupervisor: function () {

                var error = [];

                if ($('#supervisor-first-name').val().length == 0) {
                    $('#supervisor-first-name').css("border-color", clrError);
                    error.push('Supervisor First Name is required');
                }
                else {
                    $('#supervisor-first-name').css("border-color", clrDefault);
                }

                if ($('#supervisor-last-name').val().length == 0) {
                    $('#supervisor-last-name').css("border-color", clrError);
                    error.push('Supervisor last name is required');
                }
                else {
                    $('#supervisor-last-name').css("border-color", clrDefault);
                }

                if ($('#supervisor-address').val().length == 0) {
                    $('#supervisor-address').css("border-color", clrError);
                    error.push('Supervisor Address is required');
                }
                else {
                    $('#supervisor-address').css("border-color", clrDefault);
                }

                if ($('#supervisor-city-id').val().length == 0) {
                    $('#supervisor-city-id').css("border-color", clrError);
                    error.push('Supervisor City is required');
                }
                else {
                    $('#supervisor-city-id').css("border-color", clrDefault);
                }

                if ($('#supervisor-postal-code').val().length == 0) {
                    $('#supervisor-postal-code').css("border-color", clrError);
                    error.push('Supervisor Postal Code is required');
                }
                else {
                    if (!isPostalCode($('#supervisor-postal-code').val())) {
                        $('#supervisor-postal-code').css("border-color", clrError);
                        error.push('Supervisor Postal Code invalid format (A1A 1A1)');
                    }
                    else {
                        $('#supervisor-postal-code').css("border-color", clrDefault);
                    }
                }

                if ($('#supervisor-email').val().length == 0) {
                    $('#supervisor-email').css("border-color", clrError);
                    error.push('Supervisor Email is required');
                }
                else {
                    if (!isEmail($('#supervisor-email').val())) {
                        $('#supervisor-email').css("border-color", clrError);
                        error.push('Supervisor Email invalid format');
                    }
                    else {
                        $('#supervisor-email').css("border-color", clrDefault);
                    }
                }

                return error;
            },




            currencyFormat: function (num) {
                return '$' + parseFloat(num).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },

            split_str: function (str, separator, max) {
                var out = [],
                    index = 0,
                    next;

                while (!max || out.length < max - 1 ) {
                    next = str.indexOf(separator, index);
                    if (next === -1) {
                        break;
                    }
                    out.push(str.substring(index, next));
                    index = next + separator.length;
                }
                out.push(str.substring(index));
                return out;
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

</script>
