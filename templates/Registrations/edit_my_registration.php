<?php
/* This view is in two parts - the top part is the confirmation screen for the email that sends the code.
 * The bottom part is the actual edit screen for end-users to update their information
 *
  */
if ($emailConfirmation) : ?>

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



<?php //THIS IS THE USER EDIT SCREEN
if (empty($emailConfirmation)) : ?>



<?php endif; //End "edit my registration" screen ?>
