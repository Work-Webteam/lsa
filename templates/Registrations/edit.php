

<div class="container" id="app" data-spy="scroll" data-target="#registrantNav" data-offset="0">


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


    <h1 class="display-2" id="pageTitle"><?= $registration->first_name . " " . $registration->last_name ?></h1>

    <form method="post" accept-charset="utf-8" action="https://lsaapp.gww.gov.bc.ca/webroot/index.php/registrations/edit/<?= $registration->id ?>" @submit="validateForm">
    <?php

   echo $this->Form->hidden('award_options', ['value' => '']);

    echo $this->Form->hidden('accessibility_requirements_recipient');
    echo $this->Form->hidden('accessibility_requirements_guest');
    echo $this->Form->hidden('dietary_requirements_recipient');
    echo $this->Form->hidden('dietary_requirements_guest');
    ?>

    <div class="row" v-if="editPageErrors.length != 0" id="carousel-top">
        <div class="col-3">
            &nbsp;
        </div>
        <div class="col-6">
            <v-alert type="error">There are errors.
                <ul>
                    <li v-for="errorMessage in editPageErrors">{{errorMessage}}</li>
                </ul>
            </v-alert>
        </div>
        <div class="col-3"></div>
    </div>


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
                <?php
                echo $this->Form->button(__('Save Registration'), [
                    'class' => 'btn btn-primary',
                    'submit' => 'submit'
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



    <?= $this->element('editForms/awardInformation') ?>

    <?= $this->element('editForms/employeeInformation'); ?>

    <?= $this->element('editForms/workContactInfo'); ?>

    <?= $this->element('editForms/supervisorInfo'); ?>

    <?= $this->element('editForms/personalContactInfo'); ?>



    <div class="row">
        <div class="col-5">
            <?= $this->Form->button(__('Save Registration'), [
                'class' => 'btn btn-primary',

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
<?= $this->element('editForms/registrationVueObjectLoad'); ?>
