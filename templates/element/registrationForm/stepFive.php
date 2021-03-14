<h3 class="display-3">Confirm Your Information</h3>
<div class="confirmationGroup grey lighten-2">
    <h4>Milestone</h4>
    <div class="form-row">
        <div class="col-6">
            <p><small>Milestone reached:</small></p>
            <p class="confirmationValue">{{milestoneName}}</p>
        </div>
        <div class="col-6" v-if="milestone == 1">
            <p><small>Name on certificate</small></p>
            <p class="confirmationValue">{{certificateName}}</p>
        </div>
    </div>

    <div class="form-row">
        <div class="col-6">
            <p><small>Year milestone reached:</small></p>
            <p class="confirmationValue">{{award_year}}</p>
        </div>
        <div class="col-6">
            <p v-if="isRetroactive" class="confirmationValue">I registered last year but did not attend</p>
            <p v-if="awardReceived" class="confirmationValue">I received an award for this milestone</p>
            <p v-if="isRetiringThisYear" class="confirmationValue">I am retiring this year on {{retirementDate}} </p>
        </div>
    </div>
    <div class="form-row">
        <div class="col-9">

        </div>
        <div class="col-3">
            <button class="btn btn-secondary" @click.prevent="e1 = 1">Edit this Section</button>
        </div>
    </div>

</div>
<div class="confirmationGroup grey lighten-2">
    <h4>Award &amp; Options</h4>
    <div v-if="registered2019">
        <?php foreach ($awardinfo as $award): ?>
            <div class="form-row" v-if="selectedAward == <?= $award->id ?>">
                <div class="col-6">
                    <v-img src="/img/awards/<?= $award->image ?>"></v-img>
                </div>
                <div class="col-6">
                    <p class="confirmationValue"><?= $award->name ?></p>

                    <p v-if="selectedAward == 9"><small>Watch Size</small></p>
                    <p v-if="selectedAward == 9" class="confirmationValue">{{watchSize}}</p>

                    <p v-if="selectedAward == 9"><small>Watch Colour</small></p>
                    <p v-if="selectedAward == 9" class="confirmationValue">{{watchColour}}</p>

                    <p v-if="selectedAward == 9"><small>Strap Type</small></p>
                    <p v-if="selectedAward == 9" class="confirmationValue">{{strapType}}</p>

                    <p v-if="selectedAward == 9"><small>Engraving</small></p>
                    <p v-if="selectedAward == 9" class="confirmationValue">{{watchEngraving}}</p>

                    <p v-if="selectedAward == 12 || selectedAward == 46"><small>Bracelet Size</small></p>
                    <p v-if="selectedAward == 12 || selectedAward == 46" class="confirmationValue">{{braceletSize}}</p>


                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <div v-if="isRetroactive == 0">
        <div class="form-row">
            <div class="col-6">
                <p class="confirmationValue" v-if="awardReceived == 1">Selected in 2019. Talk to your organization's <a href="https://longserviceawards.gww.gov.bc.ca/contacts/">Long Service Awards contact</a> if you have questions.</p>
                <p class="confirmationValue" v-if="awardReceived == 0">Selected in 2019 but not received. The Long Service Awards team will follow up. If you have questions, reach out to your organization's <a href="https://longserviceawards.gww.gov.bc.ca/contacts">Long Service Awards contact</a>.</p>
                <p class="confirmationValue">Retroactive</p>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-9">
        </div>
        <div class="col-3">
            <button class="btn btn-secondary" @click.prevent="e1 = 2">Edit this Section</button>
        </div>
    </div>
</div>
<div class="confirmationGroup grey lighten-2">
    <h4>Your Contact Information</h4>
    <div class="form-row">
        <div class="col-6">
            <p><small>Your Name</small></p>
            <p class="confirmationValue">{{firstName}} {{lastName}}</p>
        </div>
        <div class="col-4">
            <p><small>Your Employee ID #</small></p>
            <p class="confirmationValue">{{employeeID}}</p>
        </div>
        <div class="col-2" v-if="isBcgeuMember"><p><small>Member</small></p>BCGEU</div>
    </div>
    <div class="form-row">
        <div class="col-6">
            <p><small>Your Government email address</small></p>
            <p class="confirmationValue">{{govtEmail}}</p>
        </div>
        <div class="col-6">
            <p><small>Your alternate email address</small></p>
            <p class="confirmationValue">{{altEmail}}</p>
        </div>
    </div>

    <div class="form-row">
        <div class="col-6">
            <p><small>Your current Ministry</small></p>
            <p class="confirmationValue">{{ministryName}}</p>
        </div>
        <div class="col-6">
            <p><small>Your current branch</small></p>
            <p class="confirmationValue">{{ministryBranch}}</p>
        </div>
    </div>
    <div class="form-row">
        <div class="col-6">
            <p><small>Your Office Phone #</small></p>
            <p class="confirmationValue" v-text="officePhone"></p>
            <p><small>Your Office Address</small></p>
            <p class="confirmationValue">{{officeMailPrefix}}</p>
            <p class="confirmationValue">{{officeSuite}} {{officeStreetAddress}}</p>
            <p class="confirmationValue">{{officeCityName}}, BC</p>
            <p class="confirmationValue">{{officePostalCode}}</p>
        </div>
        <div class="col-6">
            <p><small>Your Home Phone #</small></p>
            <p class="confirmationValue" v-text="homePhone">{{homePhone}}</p>
            <p><small>Your Home Address</small></p>
            <p class="confirmationValue">{{homeSuite}}</p>
            <p class="confirmationValue">{{homeStreetAddress}}</p>
            <p class="confirmationValue">{{homeCityName}}, BC</p>
            <p class="confirmationValue">{{homePostalCode}}</p>
        </div>
    </div>
    <div class="form-row">
        <div class="col-9"></div>
        <div class="col-3"><button class="btn btn-secondary" @click.prevent="e1 = 3">Edit this Section</button></div>
    </div>
</div>

<div class="confirmationGroup grey lighten-2">
    <h4>Your Supervisor&apos;s Contact Information</h4>
    <div class="form-row">
        <div class="col-6">
            <p><small>Supervisor&apos;s Name</small></p>
            <p class="confirmationValue">{{supervisorFirstName}} {{supervisorLastName}}</p>
        </div>
        <div class="col-6">
            <p><small>Supervisor&apos;s Email</small></p>
            <p class="confirmationValue">{{supervisorEmail}}</p>
        </div>
    </div>
    <div class="form-row">
        <div class="col-6">
            <p><small>Supervisor&apos;s Office Address</small></p>
            <p class="confirmationValue">{{supervisorMailPrefix}}</p>
            <p class="confirmationValue">{{supervisorSuite}} {{supervisorStreetAddress}}</p>
            <p class="confirmationValue">{{supervisorCityName}}, BC</p>
            <p class="confirmationValue">{{supervisorPostalCode}}</p>
        </div>
        <div class="col-6"></div>
    </div>
    <div class="form-row">
        <div class="col-9"></div>
        <div class="col-3"><button class="btn btn-secondary" @click.prevent="e1 = 4">Edit this Section</button></div>
    </div>
</div>


<div class="confirmationGroup grey lighten-2">
    <h4>Survey Participation &amp; Consent</h4>
    <div class="form-row">
        <div class="col-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" name="survey_participation" id="survey_participation" checked v-model="isOptedIn">
                <label class="form-check-label" for="survey_participation">
                    I Agree
                </label>
            </div>
        </div>
        <div class="col-8">
            <p class="surveyStatement">At the end of each year, a follow-up survey may be sent to collect feedback about your experience with the Long Service Awards program. By leaving this box checked, you agree to participate.</p>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="form-row">
        <div class="col-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="true" name="declaration" id="declaration" v-model="isDeclared">
                <label class="form-check-label" for="declaration">
                    I Agree
                </label>
            </div>
        </div>
        <div class="col-8">
            <p class="collectionStatement">I declare, to the best of my knowledge and consistent with the Long Service Awards eligibility guidelines (which I have reviewed) that as of
                December 31, 2021, I will have worked for the BC Public Service for 25, 30, 35, 40, 45 or 50 years and I am therefore eligible for a Long Service Award. By providing my
                personal information, I am allowing the BC Public Service Agency to use and disclose this information for the planning and delivery of the Long Service Award recognition events.
                This personal information is required to process your application for the Long Service Awards and is collected in accordance with section 26(c) of the Freedom of Information and
                Protection of Privacy Act (FOIPPA).
                Questions about the collection, use or disclosure of this information, can be directed to: LongServiceAwards@gov.bc.ca, 1st Floor, 563 Superior Street, Victoria BC, V8V 0C5.</p>
            </p>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<div class="form-row">
    <div class="col-3">
        <button class="btn btn-secondary" @click.prevent="e1 = 4">Back to Supervisor Info</button>
    </div>
    <div class="col-6">
    </div>
    <div class="col-3">
        <button type="submit" class="btn btn-primary" :disabled="isDeclared == false">Submit Registration</button>
    </div>
</div>
