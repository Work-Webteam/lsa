
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
