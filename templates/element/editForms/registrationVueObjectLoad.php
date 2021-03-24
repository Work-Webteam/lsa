<script type="text/javascript">
    app.selectedAward        = <?= $registration->award_id ?>;
    app.selectedMilestone    = <?= $registration->milestone_id ?>;
    app.pecsfRegion          = <?= is_null($registration->pecsf_region_id)       ? 'null' : $registration->pecsf_region_id ?>;
    app.pecsfCharity1        = <?= is_null($registration->pecsf_charity1_id)     ? 'null' : $registration->pecsf_charity1_id ?>;
    app.pecsfCharity2        = <?= is_null($registration->pecsf_charity2_id)     ? 'null' : $registration->pecsf_charity2_id ?>;
    app.pecsfName            = <?= is_null($registration->pecsf_name)            ? 'null' : $registration->pecsf_name ?>;

    app.accessRecipientSelections   = '<?= is_null($registration->accessibility_requirements_recipient) ? 'null' : $registration->accessibility_requirements_recipient ?>';
    app.accessGuestSelections       = '<?= is_null($registration->accessibility_requirements_guest) ? 'null' : $registration->accessibility_requirements_guest ?>';
    app.dietRecipientSelections     = '<?= is_null($registration->dietary_requirements_recipient) ? 'null' : $registration->dietary_requirements_recipient; ?>';
    app.dietGuestSelections         = '<?= is_null($registration->dietary_requirements_guest) ? 'null' : $registration->dietary_requirements_guest ?>';

    app.milestone              = <?= empty($registration->milestone_id) ? 'null' : $registration->milestone_id ?>;
    app.award_year             = <?= empty($registration->award_year) ? 'null' : $registration->award-year ?>';
    app.isRetiringThisYear     = <?= empty($registration->retiring_this_year)   ? 'false' : 'true' ?>;
    app.retirementDate         = '<?= $registration->retirement_date   ?>';
    app.awardReceived          = <?= empty($registration->award_recieved) ? 'null' : $registration->award_recieved ?>;
    app.certificateName        = '<?= $registration->certificate_name ?>';

    app.isRetroactive          = <?= $registration->retroactive ? 'true' : 'false' ?>;

    app.employeeID             = <?= $registration->employee_id ?>;
    app.isBcgeuMember          = <?= $registration->member_bcgeu ? $registration->member_bcgeu : 'null' ?>;
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
    app.officeCity             = <?=  $registration->office_city_id ?>;
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

    app.isOptedIn              = '<?= is_null($registration->survey_participation) ? 'false' : $registration->survey_participation ?>';
    app.originalAward          = <?= $registration->award_id ?>;
    app.parseAwardOptions();

</script>
