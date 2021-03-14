

<?php
/* This view is in two parts - the top part is the confirmation screen for the email that sends the code.
 * The bottom part is the actual edit screen for end-users to update their information
 *
  */
if (!empty($emailConfirmation) && $emailConfirmation === true) : ?>

<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
        <h1>Link Sent!</h1>
        <p></p>
        <p>If the email address you entered matches a registration on record, you should receive your email link soon.</p>
        <p>It might take a few minutes for the email to arrive in your inbox. If nothing arrives, please connect with your <a href="https://longserviceawards.gww.gov.bc.ca/contacts/">Long Service Awards Contact</a></p>
        <p>Please note, if your email address was misentered on the registration form we can't send you a link! Reach out to your <a href="https://longserviceawards.gww.gov.bc.ca/contacts/">Long Service Awards contact</a> for assistance.</p>
    </div>
    <div class="col-3"></div>
</div>

<?php endif; //End "email sent" confirmation screen ?>

<?php if (!empty($editSuccessMessage) && $editSuccessMessage === true) : ?>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6"><h1>Edits Submitted!</h1>
            <p>Your registration information has been updated.</p>
        </div>
        <div class="col-3"></div>
    </div>

<?php endif; //End success message logic; ?>

<?php if (empty($editSuccessMessage)) : ?>
    <div class="container" id="app" data-spy="scroll" data-target="#registrantNav" data-offset="0">
        <h1 class="display-2"><?= $registration->first_name . " " . $registration->last_name ?></h1>

        <?php
        echo $this->Form->create($registration);

        echo $this->Form->hidden('return_path');
        echo $this->Form->hidden('award_options', ['value' => '']);
        echo $this->Form->hidden('accessibility_requirements_recipient');
        echo $this->Form->hidden('accessibility_requirements_guest');
        echo $this->Form->hidden('dietary_requirements_recipient');
        echo $this->Form->hidden('dietary_requirements_guest');
        echo $this->Form->hidden('edit_code');
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


            <?= $this->element('editForms/awardInformation');?>
            <?= $this->element('editForms/employeeInformation'); ?>
            <?= $this->element('editForms/workContactInfo'); ?>
            <?= $this->element('editForms/supervisorInfo'); ?>
            <?= $this->element('editForms/personalContactInfo'); ?>

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


<?php endif; //End form presentation ?>

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
