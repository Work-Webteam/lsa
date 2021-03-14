<h3 class="display-3">Milestone</h3>
<div class="row" v-if="errorsStep1.length">
    <div class="col-3">
        &nbsp;
    </div>
    <div class="col-6">
        <v-alert type="error">There are errors.
            <ul>
                <li v-for="error in errorsStep1">{{error}}</li>
            </ul>
        </v-alert>
    </div>
    <div class="col-3"></div>
</div>


<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="milestone">Which milestone are you celebrating?</label>
            <select class="form-control with-arrow" id="milestone_id" name="milestone_id" v-model="milestone" @change="setMilestoneName">
                <option selected disabled>Select Milestone</option>
                <?php foreach ($milestoneinfo as $mstone) : ?>
                    <option value="<?= $mstone->id ?>"><?= $mstone->name ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="award_year">In which year did you reach this milestone?</label>
            <select class="form-control with-arrow" id="award_year" name="award_year" v-model="award_year">
                <option selected disabled>Select Year</option>

                <?php foreach ($award_years as $ayear) : ?>
                    <option value="<?= $ayear ?>"><?= $ayear ?></option>
                <?php endforeach ?>

            </select>
            <small id="awardYearHelpBlock" class="form-text text-muted">If the year you reached this milestone isn't listed, contact your organization's Long Service Awards contact.</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group" v-if="milestone == 1">
            <label for="">All 25 year awards come with a framed certificate of service signed by the Premier of British Columbia. How would you like your name to appear on your certificate?</label>
            <input type="text" id="certificateName" name="certificate_name" v-model="certificateName" class="form-control">
        </div>
    </div>
    <div class="col-3">
            <p>Did you register for a Long Service Award in 2019?</p>
            <div class="form-group checkbox-group">
                <input class="form-check-input" type="radio" name="retroactive" id="retroactive" value="1" v-model="registered2019" >
                <label class="form-check-label" for="retroactive">Yes</label>
            </div>
            <div class="form-group checkbox-group">
                <input class="form-check-input" type="radio" name="retroactive" id="retroactive" value="0" checked v-model="registered2019" >
                <label class="form-check-label" for="retroactive">No</label>
            </div>
            <div v-if="registered2019 == 1">
            <p>Did you receive your award?</p>
            <div class="form-group checkbox-group">
                <input class="form-check-input" type="radio" name="award_received" id="award_received" checked value="1" v-model="awardReceived" >
                <label class="form-check-label" for="award_received">Yes</label>
            </div>
            <div class="form-group checkbox-group">
                <input class="form-check-input" type="radio" name="award_received" id="award_received"  value="0" v-model="awardReceived">
                <label class="form-check-label" for="award_received">No</label>
            </div>
            </div>
    </div>
    <div class="col-3">
        <p>Are you retiring this year?</p>
        <div class="form-group checkbox-group">
            <input class="form-check-input" type="radio" name="retiring_this_year" id="retiring_this_year" value="1" v-model="isRetiringThisYear">
            <label class="form-check-label" for="retiring_this_year">Yes</label>
        </div>
        <div class="form-group checkbox-group">
            <input class="form-check-input" type="radio" name="retiring_this_year" id="retiring_this_year" value="0" checked v-model="isRetiringThisYear">
            <label class="form-check-label" for="retiring_this_year">No</label>
        </div>


        <div class="form-group" v-if="isRetiringThisYear == 1">
            <label for="retirement_date">Date of Retirement:</label>
            <input type="date" class="form-control" name="retirement_date" id="retirement_date" v-model="retirementDate" min="2021-01-01" max="2021-12-31">
        </div>
    </div>
</div>


<div class="row">
    <div class="col-3">
    </div>
    <div class="col-6">
    </div>
    <div class="col-3">
        <button id="award-button" class="btn btn-primary" @click.prevent="validateStep1();" >Select Award</button>
    </div>
</div>

