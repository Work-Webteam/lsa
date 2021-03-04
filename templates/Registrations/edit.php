<div class="container" id="app">
    <h1 class="display-2"><?= $registration->first_name . " " . $registration->last_name ?></h1>

    <?php
    echo $this->Form->create($registration);

    echo $this->Form->hidden('return_path');

    echo $this->Form->hidden('award_options', ['value' => '']);

    echo $this->Form->hidden('accessibility_requirements_recipient');
    echo $this->Form->hidden('accessibility_requirements_guest');
    echo $this->Form->hidden('dietary_requirements_recipient');
    echo $this->Form->hidden('dietary_requirements_guest');
    ?>

    <?php if ($isadmin) : ?>
        <div class="row"> <h2>Process Information</h2></div>


        <div class="row">
            <div class="col-2">
                <?= $this->Form->control('registration_year', ['label' => 'Registration Year', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('qualifying_year', ['label' => 'Award Year', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('award_received', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('engraving_sent', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('certificate_ordered', ['class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('pecsf_cheque_date', ['class' => 'form-control']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <?= $this->Form->control('survey_participation', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('invite_sent', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('photo_order', ['class' => 'form-control', ]); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('photo_frame_range', ['class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('photo_sent', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <?= $this->Form->control('certificate_name', ['class' => 'form-control']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('award_instructions', ['label' => 'Award Instructions', 'type' => 'textarea', 'class' => 'form-control']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('admin_notes', ['class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">  <h2>Ceremony Information</h2></div>



        <div class="row">
            <div class="col-4">
                <?= $this->Form->control('ceremony_id', ['label' => 'Ceremony Night', 'class' => 'form-control', 'options' => $ceremonies, 'empty' => '- select ceremony -']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('presentation_number', ['label' => 'Award Presentation #', 'class' => 'form-control']); ?>
            </div>
            <div class="col-4">

            </div>
        </div>
        <div class="row">
            <div class="col-1">
                <?= $this->Form->control('responded', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-1">
                <?= $this->Form->control('attending', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-1">
                <?= $this->Form->control('guest', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-1">
                <?= $this->Form->control('noshow', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-1">
                <?= $this->Form->control('waitinglist', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-1">
                <?= $this->Form->control('recipient_speaker', ['label' => 'Speaker', 'type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-1">
                <?= $this->Form->control('reserved_seating', ['type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-1">
                <?= $this->Form->control('executive_recipient', ['label' => 'Executive', 'type' => 'checkbox', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
            </div>
        </div>


        <div class="row">
            <div class="col-10"><h3>Accessibility Information</h3></div>
            <div class="col-2">
                <button class="btn btn-primary" type="button" data-toggle="collapse"
                        data-target="#accessibility-requirements" aria-expanded="false" aria-controls="accessibility-requirements">Edit
                </button>
            </div>
        </div>


        <div class="row collapse" id="accessibility-requirements">
            <?php foreach ($accessibility as $item): ?>
                <div class="col-2">
                    <div class="form-group">
                        <input class="form-control" type="checkbox" id="accessR-<?= $item->id ?>"
                               value="<?= $item->id ?>" v-model="accessRecipientSelections">
                        <label for="accessR-<?= $item->id ?>"><?= $item->name ?></label>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-4">
                <?= $this->Form->control('accessibility_recipient_notes', ['label' => 'Recipient Accessibility Notes', 'class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-10"><h3>Guest Accessibility Information</div>
            <div class="col-2">
                <button class="btn btn-primary" type="button" data-toggle="collapse"
                        data-target="#guest-accessibility-requirements" aria-expanded="false" aria-controls="guest-accessibility-requirements">
                    Edit
                </button>
            </div>
        </div>

        <div class="row collapse" id="guest-accessibility-requirements">
            <?php foreach ($accessibility as $item): ?>
                <div class="col-2">
                    <div class="form-group">
                        <input class="form-control" type="checkbox" id="accessG-<?= $item->id ?>"
                               value="<?= $item->id ?>" v-model="accessGuestSelections">
                        <label for="accessG-<?= $item->id ?>"><?= $item->name ?></label>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-4">
                <?= $this->Form->control('accessibility_guest_notes', ['label' => 'Guest Accessibility Notes', 'class' => 'form-control']); ?>
            </div>
        </div>


        <div class="row">
            <div class="col-10"><h3>Dietary Options</div>
            <div class="col-2">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#dietary-restrictions"
                        aria-expanded="false" aria-controls="dietary-restrictions">Edit
                </button>
            </div>
        </div>

        <div class="row collapse" id="dietary-restrictions">
            <?php foreach ($diet as $item): ?>
                <div class="col-2">
                    <div class="form-group">
                        <input class="form-control" type="checkbox" id="dietR-<?= $item->id ?>" value="<?= $item->id ?>"
                               v-model="dietRecipientSelections">
                        <label for="dietR-<?= $item->id ?>"><?= $item->name ?></label>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-4">
                <?= $this->Form->control('dietary_recipient_other', ['label' => 'Dietary Restriction Notes', 'class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-10"><h3>Guest Dietary Options </h3></div>
            <div class="col-2">
                <button class="btn btn-primary" type="button" data-toggle="collapse"
                        data-target="#guest-dietary-restrictions" aria-expanded="false" aria-controls="guest-dietary-restrictions">Edit
                </button>
            </div>
        </div>

        <div class="row collapse" id="guest-dietary-restrictions">
            <?php foreach ($diet as $item): ?>
                <div class="col-2">
                    <div class="form-group">
                        <input class="form-control" type="checkbox" id="dietG-<?= $item->id ?>" value="<?= $item->id ?>"
                               v-model="dietGuestSelections">
                        <label for="dietG-<?= $item->id ?>"><?= $item->name ?></label>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-4">
                <?= $this->Form->control('dietary_guest_other', ['label' => 'Dietary Restriction Notes', 'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-9">

            </div>
            <div class="col-3">
                <?php
                echo $this->Form->button(__('Save Registration'), [
                    'class' => 'btn btn-primary'
                ]);
                echo '&nbsp;';
                echo $this->Form->button('Cancel', array(
                    'type' => 'button',
                    'onclick' => 'location.href="' . $registration->return_path . '"',
                    'class' => 'btn btn-secondary'
                ));

                ?>
            </div>
        </div>

    <?php endif; //END Admin-only inputs ?>

    <div class="row"> <h2>Employee Information</h2></div>



    <div class="form-row">

        <div class="col-4">
            <div class="form-group">
                <?= $this->Form->control('employee_id', ['type'=> 'text', 'class' => 'form-control', 'label' => 'Employee ID', 'value' => $registration->employee_id]); ?>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <?= $this->Form->control('first_name', ['class' => 'form-control', 'label' => 'First Name']); ?>
            </div>
        </div>
        <div class="col-4">
            <?= $this->Form->control('last_name', ['class' => 'form-control', 'label' => 'Last Name']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('ministry_id', ['type' => 'select', 'options' => $ministries, 'class' => 'form-control', 'label' => 'Member Organization', 'empty' => '- select ministry -']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('branch', ['label' => 'Branch', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">

        </div>
    </div>

    <div class="row">
        <div class="col-4">

        </div>
        <div class="col-4">

        </div>
        <div class="col-4">

        </div>
    </div>

    <div class="row"> <h2>Work Contact Information</h2></div>


    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('preferred_email', ['label' => 'Government Email', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('work_phone', ['label' => 'Phone', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('work_extension', ['label' => 'Phone Extension', 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('office_careof', ['label' => 'Floor/ Room / Care Of', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_suite', ['label' => 'Suite', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_address', ['label' => 'Address', 'class' => 'form-control']); ?>

        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('office_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_postal_code', ['label' => 'Postal Code', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">

        </div>
    </div>

    <div class="row"> <h2>Supervisor Information</h2></div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('supervisor_first_name', ['label' => 'Supervisor First Name', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_last_name', ['label' => 'Supervisor Last Name', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_email', ['label' => 'Supervisor Email', 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('supervisor_careof', ['label' => 'Floor / Room / Care Of', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_suite', ['label' => 'Suite', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_address', ['label' => 'Address', 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('supervisor_city_id', ['label' => 'City', 'class' => 'form-control', 'options' => $cities, 'empty' => '- select city -']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_postal_code', ['label' => 'Postal Code', 'class' => 'form-control',]); ?>
        </div>
        <div class="col-4">

        </div>
    </div>


   <div class="row"><h2>Personal Contact Information</h2></div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('alternate_email', ['label' => 'Home Email', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_phone', ['label' => 'Phone', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">

        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('home_suite', ['label' => 'Suite', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_address', ['label' => 'Address', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('home_postal_code', ['label' => 'Postal Code', 'class' => 'form-control']); ?>
        </div>
    </div>

    <div class="row"> <h2>Award Information</h2></div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('milestone_id', ['options' => $milestones, 'class'=> 'form-control','v-model' => 'selectedMilestone']); ?>
            <?= $this->Form->hidden('award_id', ['value' => 0, 'v-model' => 'selectedAward']);?>
        </div>
        <div class="col-8">
            <div class="form-group">
            <label for="award_id">Select Award</label>
            <select name="award_id" id="award_id" v-model="selectedAward" class="form-control">
                <?php foreach ($awards as $award): ?>
                    <option value="<?= $award->id ?>" v-if="selectedMilestone == <?= $award->milestone_id; ?>"><?= $award->name ?></option>
                <?php endforeach; ?>
            </select>
            </div>
            <!-- WATCH CONTROLS -->
            <div v-if="selectedAward == watchID">
                    <div class="form-group">
                        <label for="watch_size"> Watch Size:</label>
                        <select class="form-control" name="watch_size" id="watch_size">
                            <option disabled selected>Select Watch Size</option>
                            <option>38mm face with 20mm strap</option>
                            <option>29mm face with 14mm strap</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="watch_colour">Watch Colour:</label>
                        <select class="form-control" name="watch_colour" id="watch_colour">
                            <option disabled selected></option>
                            <option>Gold</option>
                            <option>Silver</option>
                            <option>Two-Toned (Gold &amp;s Silver)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="strap_type">Strap:</label>
                        <select  class="form-control" name="strap_type" id="strap_type">
                            <option disabled selected>Choose Strap</option>
                            <option>Plated</option>
                            <option>Black Leather</option>
                            <option>Brown Leather</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="watch_engraving">Engraving</label>
                        <input class="form-control" type="text" name="watch_engraving" maxlength="33">
                    </div>
            </div>

            <!-- 35 YR BRACELET CONTROLS -->
            <div v-if="selectedAward == bracelet35ID">
                <div class="form-group">
                    <label for="bracelet_size">Size</label>
                    <select  class="form-control" name="bracelet_size" id="bracelet_size">
                        <option disabled selected>Choose Size</option>
                        <option>Fits 6 1/2" - 7 1/2" circumference wrists</option>
                        <option>Fits 7 1/2" - 8 1/2" circumference wrists</option>
                    </select>
                </div>
            </div>

            <!-- 45 YR BRACELET CONTROLS -->
            <div v-if="selectedAward == bracelet45ID">
                <div class="form-group">
                    <label for="bracelet_size">Size</label>
                    <select class="form-control" name="bracelet_size" id="bracelet_size">
                        <option disabled selected>Choose Size</option>
                        <option>Fits 6 1/2" - 7 1/2" circumference wrists</option>
                        <option>Fits 7 1/2" - 8 1/2" circumference wrists</option>
                    </select>
                </div>
            </div>

            <!-- PECSF DONATION CONTROLS -->
            <div v-if="selectedAward == pecsf25ID || selectedAward == pecsf30ID || selectedAward == pecsf35ID || selectedAward == pecsf40ID || selectedAward == pecsf45ID || selectedAward == pecsf50ID">

                    <div class="form-group">
                        <label for="">Name on Donation</label>
                        <input class="form-control" type="text" maxlength="33" placeholder="Firstname Lastname">
                    </div>
                    <div  class="form-group">
                        <label for="pecsf_region">Your Desired PECSF Region</label>
                        <select class="form-control" name="pecsf_region" id="pecsf_region" v-model="pecsfRegion">
                            <?php foreach ($regions as $region) : ?>
                                <option value="<?= $region->id ?>"><?= $region->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="donation_type" id="donation_type" value="pool" v-model="donationType" checked>
                        <label class="form-check-label" for="">Donate to the fund-supported pool for my chosen region</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="donation_type" id="donation_type" value="single-charity" v-model="donationType">
                        <label class="form-check-label" for="">Donate to a specific charity</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="donation_type" id="donation_type" value="two-charities" v-model="donationType">
                        <label class="form-check-label" for="">Donate to two charities</label>
                    </div>
                    <div class="form-group" >
                        <label for="pecsf_charity_1" v-if="donationType == 'single-charity'">Choose your charity</label>
                        <label for="pecsf_charity_1" v-if="donationType == 'two-charities'">Choose your first charity</label>
                        <select class="form-control"  name="pecsf_charity_1" v-if="donationType != 'pool'" id="pecsf_charity_1" v-model="pecsfCharity1">
                            <option selected disabled>Choose a charity</option>
                            <?php foreach ($charities as $charity): ?>
                                <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id; ?>"><?= $charity->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group" v-if="donationType == 'two-charities'">
                        <label for="pecsf_charity_2">Choose your second charity</label>
                        <select class="form-control" name="pecsf_charity_2" id="pecsf_charity_2" v-model="pecsfCharity2">
                            <option selected disabled>Choose a charity</option>
                            <?php foreach ($charities as $charity): ?>
                                <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id; ?>"><?= $charity->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
            </div>
    </div>

    <div class="row">
        <div class="col-9">

        </div>
        <div class="col-3">
            <?php
            echo $this->Form->button(__('Save Registration'), [
                'class' => 'btn btn-primary'
            ]);
            echo '&nbsp;';
            echo $this->Form->button('Cancel', array(
                'type' => 'button',
                'onclick' => 'location.href="' . $registration->return_path . '"',
                'class' => 'btn btn-secondary'
            ));
            echo $this->Form->end();
            ?>
        </div>
    </div>



<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>

<script type="text/javascript">

    var app = new Vue({
        el: '#app',
        data : {
            selectedAward:      <?= $registration->award_id ?>,
            originalAward:      <?= $registration->award_id ?>,
            selectedMilestone:  <?= $registration->milestone_id ?>,

            //MAGIC NUMBERS
            //IDs of Awards with options
            watchID: 9,
            bracelet35ID: 12,
            bracelet45ID: 46,
            pecsf25ID: 49,
            pecsf30ID: 50,
            pecsf35ID: 51,
            pecsf40ID: 52,
            pecsf45ID: 53,
            pecsf50ID: 54,

            pecsfRegion: '',
            donationType: 'pool',
            pecsfCharity1: '',
            pecsfCharity2: '',

            accessRecipientSelections:  <?= $registration->accessibility_requirements_recipient ?>,
            accessGuestSelections :     <?= $registration->accessibility_requirements_guest ?>,
            dietRecipientSelections:    <?= $registration->dietary_requirements_recipient; ?>,
            dietGuestSelections:        <?= $registration->dietary_requirements_guest; ?>,

            errorsOptions: '',




        }
    })

</script>
