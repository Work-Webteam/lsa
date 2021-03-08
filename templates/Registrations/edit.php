

<div class="container" id="app" data-spy="scroll" data-target="#registrantNav" data-offset="0">
    <?php if ($isadmin) : ?>

            <nav id="registrantNav" class="navbar navbar-light bg-light sticky-top">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link" href="#processInfo" >Process</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#ceremonyInfo">Ceremony</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#awardInfo">Award</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#employeeInfo">Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#workContact">Work Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#supervisorInfo">Supervisor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#personalContact">Personal Contact</a>
                    </li>
                </ul>
            </nav>

    <?php endif; ?>

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

    <div class="row" v-if="editFormErrors">
        <div class="col-3">
            &nbsp;
        </div>
        <div class="col-6">
            <v-alert type="error">There are errors.
                <ul>
                    <li v-if="errorsStep1.length" v-for="error in errorsStep1">{{error}}</li>
                    <li v-if="errorsStep2.length" v-for="error in errorsStep2">{{error}}</li>
                    <li v-if="errorsStep3.length" v-for="error in errorsStep3">{{error}}</li>
                    <li v-if="errorsStep4.length" v-for="error in errorsStep4">{{error}}</li>
                </ul>
            </v-alert>
        </div>
        <div class="col-3"></div>
    </div>

    <?php if ($isadmin) : ?>

        <div class="row"> <h2 id="processInfo">Process Information</h2></div>
        <div class="row">
            <div class="col-2">
                <?= $this->Form->control('registration_year', ['label' => 'Registration Year', 'class' => 'form-control']); ?>
            </div>
            <div class="col-2">
                <?= $this->Form->control('award_year', ['label' => 'Award Year', 'class' => 'form-control', 'v-model' => 'award_year']); ?>
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
                <?= $this->Form->control('survey_participation', ['type' => 'checkbox', 'class' => 'form-control', 'v-model' => 'isOptedIn']); ?>
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
                <?= $this->Form->control('certificate_name', ['class' => 'form-control', 'v-model' => 'certificateName']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('award_instructions', ['label' => 'Award Instructions', 'type' => 'textarea', 'class' => 'form-control']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('admin_notes', ['class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">  <h2 id="ceremonyInfo">Ceremony Information</h2></div>



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
            <div class="col-8">

            </div>
            <div id="awardInfo" class="col-4">
                <button class="btn btn-primary" @click.prevent="validateForm">Check Form</button>
                <?php
                echo $this->Form->button(__('Save Registration'), [
                    'class' => 'btn btn-primary',
                    ':disabled' => 'formIsValid == false'
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

    <div class="row"> <h2 >Award Information</h2></div>

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
                    <select class="form-control" name="watch_size" id="watch_size" v-model="watchSize">
                        <option disabled selected>Select Watch Size</option>
                        <option>38mm face with 20mm strap</option>
                        <option>29mm face with 14mm strap</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="watch_colour">Watch Colour:</label>
                    <select class="form-control" name="watch_colour" id="watch_colour" v-model="watchColour">
                        <option disabled selected></option>
                        <option>Gold</option>
                        <option>Silver</option>
                        <option>Two-Toned (Gold &amp; Silver)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="strap_type">Strap:</label>
                    <select  class="form-control" name="strap_type" id="strap_type" v-model="strapType">
                        <option disabled selected>Choose Strap</option>
                        <option>Plated</option>
                        <option>Black Leather</option>
                        <option>Brown Leather</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="watch_engraving">Engraving</label>
                    <input class="form-control" type="text" name="watch_engraving" maxlength="33" v-model="watchEngraving">
                </div>
            </div>

            <!-- 35 YR BRACELET CONTROLS -->
            <div v-if="selectedAward == bracelet35ID">
                <div class="form-group">
                    <label for="bracelet_size">Size</label>
                    <select  class="form-control" name="bracelet_size" id="bracelet_size" v-model="braceletSize">
                        <option disabled value="">Choose Size</option>
                        <option>Fits 6 ½″ - 7 ½″ circumference wrists</option>
                        <option>Fits 7 ½″ - 8 ½″ circumference wrists</option>
                    </select>
                </div>
            </div>

            <!-- 45 YR BRACELET CONTROLS -->
            <div v-if="selectedAward == bracelet45ID">
                <div class="form-group">
                    <label for="bracelet_size">Size</label>
                    <select class="form-control" name="bracelet_size" id="bracelet_size" v-model="braceletSize">
                        <option disabled value="">Choose Size</option>
                        <option>Fits 6 ½″ - 7 ½″ circumference wrists</option>
                        <option>Fits 7 ½″ - 8 ½″ circumference wrists</option>
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


    <div class="row"> <h2 id="employeeInfo">Employee Information</h2> </div>



    <div class="row">
        <div class="col-2">
            <?= $this->Form->control('employee_id', ['type'=> 'text', 'class' => 'form-control', 'label' => 'Employee ID', 'value' => $registration->employee_id , 'v-model' => 'employeeID']); ?>
        </div>
        <div class="col-2">
            <?= $this->Form->control('member_bcgeu', ['class' => 'form-control', 'label' => 'Member of BCGEU', 'v-model' => 'isBcgeuMember']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('first_name', ['class' => 'form-control', 'label' => 'First Name', 'v-model' => 'firstName']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('last_name', ['class' => 'form-control', 'label' => 'Last Name', 'v-model' => 'lastName']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('ministry_id', ['type' => 'select', 'options' => $ministries, 'class' => 'form-control', 'label' => 'Member Organization', 'empty' => '- select ministry -', 'v-model' => 'ministry']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('branch', ['label' => 'Branch', 'class' => 'form-control']); ?>
        </div>
        <div class="col-4">

        </div>
    </div>

    <div class="row"> <h2 id="workContact">Work Contact Information</h2></div>


    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('preferred_email', ['label' => 'Government Email', 'class' => 'form-control', 'v-model' => 'govtEmail']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('work_phone', ['label' => 'Phone', 'class' => 'form-control', 'v-model' => 'officePhone']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('work_extension', ['label' => 'Phone Extension', 'class' => 'form-control', 'v-model' => 'officeExtension' ]); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_careof', ['label' => 'Floor/ Room / Care Of', 'class' => 'form-control', 'v-model' => 'officeMailPrefix']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_suite', ['label' => 'Suite', 'class' => 'form-control', 'v-model' => 'officeSuite']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_address', ['label' => 'Address', 'class' => 'form-control', 'v-model' => 'officeStreetAddress']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -', 'class' => 'form-control', 'v-model' => 'officeCity']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('office_postal_code', ['label' => 'Postal Code', 'class' => 'form-control', 'v-model' => 'officePostalCode']); ?>
        </div>
        <div class="col-4">
        </div>
    </div>

    <div class="row"><h2 id="supervisorInfo">Supervisor Information</h2></div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('supervisor_first_name', ['label' => 'Supervisor First Name', 'class' => 'form-control', 'v-model' => 'supervisorFirstName']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_last_name', ['label' => 'Supervisor Last Name', 'class' => 'form-control', 'v-model' => 'supervisorLastName']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_email', ['label' => 'Supervisor Email', 'class' => 'form-control', 'v-model' => 'supervisorEmail']); ?>
        </div>

        <div class="col-4">
            <?= $this->Form->control('supervisor_careof', ['label' => 'Floor / Room / Care Of', 'class' => 'form-control', 'v-model' => 'supervisorMailPrefix']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_suite', ['label' => 'Suite', 'class' => 'form-control', 'v-model' => 'supervisorSuite']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_address', ['label' => 'Address', 'class' => 'form-control', 'v-model' => 'supervisorStreetAddress']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_city_id', ['label' => 'City', 'class' => 'form-control', 'options' => $cities, 'empty' => '- select city -', 'v-model' => 'supervisorCity']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('supervisor_postal_code', ['label' => 'Postal Code', 'class' => 'form-control', 'v-model' => 'supervisorPostalCode']); ?>
        </div>
        <div class="col-4">
        </div>
    </div>


   <div class="row"><h2 id="personalContact">Personal Contact Information</h2></div>

    <div class="row">
        <div class="col-4">
            <?= $this->Form->control('alternate_email', ['label' => 'Home Email', 'class' => 'form-control', 'v-model' => 'altEmail']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_phone', ['label' => 'Phone', 'class' => 'form-control', 'v-model' => 'homePhone']); ?>
        </div>
        <div class="col-4">
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_suite', ['label' => 'Suite', 'class' => 'form-control', 'v-model' => 'homeSuite']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_address', ['label' => 'Address', 'class' => 'form-control', 'v-model' => 'homeStreetAddress']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -', 'class' => 'form-control', 'v-model' => 'homeCity']); ?>
        </div>
        <div class="col-4">
            <?= $this->Form->control('home_postal_code', ['label' => 'Postal Code', 'class' => 'form-control', 'v-model' => 'homePostalCode']); ?>
        </div>
    </div>



    <div class="row">
        <div class="col-5">
            <button class="btn btn-primary" @click.prevent="validateForm">Check Form</button>
            <?= $this->Form->button(__('Save Registration'), [
                'class' => 'btn btn-primary',
                ':disabled' => 'formIsValid == false'
            ]) ?>
            <?= $this->Form->button('Cancel', array(
                'type' => 'button',
                'onclick' => 'location.href="' . $registration->return_path . '"',
                'class' => 'btn btn-secondary'
            )) ?>
            <?= $this->Form->end(); ?>

        </div>
        <div class="col-4"></div>
        <div class="col-3">

            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $registration->id],
                ['confirm' => 'Are you sure? This cannot be undone.','class' => 'btn btn-primary delete', 'role' => 'button'])
            ?>
        </div>
    </div>
    </div>
</div>

<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js" integrity="sha512-XKa9Hemdy1Ui3KSGgJdgMyYlUg1gM+QhL6cnlyTe2qzMCYm4nAZ1PsVerQzTTXzonUR+dmswHqgJPuwCq1MaAg==" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>
    <!-- Registration Form-specific JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js" integrity="sha512-VpQwrlvKqJHKtIvpL8Zv6819FkTJyE1DoVNH0L2RLn8hUPjRjkS/bCYurZs0DX9Ybwu9oHRHdBZR9fESaq8Z8A==" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

<script src="/js/registration/registration-info.js"></script>

<script type="text/javascript">
    app.certificateName        = "THIS IS A NAME";

app.selectedAward        = <?= $registration->award_id ?>;
app.selectedMilestone    = <?= $registration->milestone_id ?>;
app.pecsfRegion          = <?= is_null($registration->pecsf_region_id)       ? 'null' : $registration->pecsf_region_id ?>;
app.pecsfCharity1        = <?= is_null($registration->pecsf_charity1_id)     ? 'null' : $registration->pecsf_charity1_id ?>;
app.pecsfCharity2        = <?= is_null($registration->pecsf_charity2_id)     ? 'null' : $registration->pecsf_charity2_id ?>;
app.pecsfName            = <?= is_null($registration->pecsf_name)            ? 'null' : $registration->pecsf_name ?>;

app.accessRecipientSelections   = <?= is_null($registration->accessibility_requirements_recipient) ? 'null' : $registration->accessibility_requirements_recipient ?>;
app.accessGuestSelections       = <?= is_null($registration->accessibility_requirements_guest) ? 'null' : $registration->accessibility_requirements_guest ?>;
app.dietRecipientSelections     = <?= is_null($registration->dietary_requirements_recipient) ? 'null' : $registration->dietary_requirements_recipient; ?>;
app.dietGuestSelections         = <?= is_null($registration->dietary_requirements_guest) ? 'null' : $registration->dietary_requirements_guest ?>;

app.milestone              = <?= $registration->milestone_id ?>;
app.award_year             = '<?= $registration->award_year ?>';
app.isRetiringThisYear     = <?= $registration->retiring_this_year   ? 'true' : 'false' ?>;
app.retirementDate         = '<?= is_null($registration->retirement_date)       ? 'null' : $registration->retirement_date ?>';
app.certificateName        = <?= is_null($registration->certificate_name)     ? 'null' : $registration->certificate_name ?>;

app.isRetroactive          = <?= $registration->retroactive ? 'true' : 'false' ?>;

app.employeeID             = <?= $registration->employee_id ?>;
app.isBcgeuMember          = <?= is_null($registration->member_bcgeu) ? 'null' : $registration->member_bcgeu ?>;
app.firstName              = '<?= $registration->first_name ?>';
app.lastName               = '<?= $registration->last_name ?>';

app.selectedAward          = <?= $registration->award_id ?>;
app.awardOptions           = <?= $registration->award_options ?>;

app.donationRegion         = <?= is_null($registration->pecsf_region_id)    ? 'null' : $registration->pecsf_region_id ?>;
app.donationCharity1       = <?= is_null($registration->pecsf_charity1_id)  ? 'null' : $registration->pecsf_charity1_id ?>;
app.donationCharity2       = <?= is_null($registration->pecsf_charity2_id)  ? 'null' : $registration->pecsf_charity2_id ?>;

app.govtEmail              = '<?= $registration->preferred_email ?>';
app.altEmail               = '<?= $registration->alternate_email ?>';

app.ministry               = <?= $registration->ministry_id ?>;
app.ministryBranch         = '<?= $registration->branch ?>';

app.officeMailPrefix       = '<?= $registration->office_careof ?>';
app.officeSuite            = '<?= $registration->office_suite ?>';
app.officeStreetAddress    = '<?= $registration->office_address ?>';
app.officeCity             = <?= $registration->office_city_id ?>;
app.officePostalCode       = '<?= $registration->office_postal_code ?>';
app.officePhone            = '<?= $registration->work_phone ?>';
app.officeExtension        = '<?= $registration->work_extension ?>';

app.homeMailPrefix         = '<?= $registration->home_careof ?>';
app.homeSuite              = '<?= $registration->home_suite ?>';
app.homeStreetAddress      = '<?= $registration->home_address ?>';
app.homeCity               = <?= $registration->home_city_id ?>;
app.homePostalCode         = '<?= $registration->home_postal_code ?>';
app.homePhone              = '<?= $registration->home_phone ?>';

app.supervisorFirstName        = '<?= $registration->supervisor_first_name ?>';
app.supervisorLastName         = '<?= $registration->supervisor_last_name ?>';
app.supervisorMailPrefix       = '<?= $registration->supervisor_careof ?>';
app.supervisorSuite            = '<?= $registration->supervisor_suite ?>';
app.supervisorStreetAddress    = '<?= $registration->supervisor_address ?>';
app.supervisorCity             = <?= $registration->supervisor_city_id ?>;
app.supervisorPostalCode       = '<?= $registration->supervisor_postal_code ?>';
app.supervisorEmail            = '<?= $registration->supervisor_email ?>';

app.isOptedIn              = <?= is_null($registration->survey_participation) ? 'false' : $registration->survey_participation ?>;
app.originalAward          = <?= $registration->award_id ?>;
app.parseAwardOptions();

</script>

