<h3 class="display-3">Select Your Award</h3>

<v-carousel v-on:change="highlightedAward = servicesCarouselItems[$event].awardid" light>
    <?php foreach ($awardinfo as $award): ?>
        <v-carousel-item awardID="<?= $award->id ?>" v-if="milestone == <?= $award->milestone_id; ?>" >
            <v-sheet height="100%" width="100%" tile>
                <v-row no-gutters>
                    <v-col cols="6"><v-img src="/img/awards/<?= $award->image ?>"></v-img></v-col>
                    <v-col cols="6">
                        <v-row align="center" justify="space-around"><v-col cols="12"><h3 class="award-title text-center display-2"><?= $award->name ?></h3></v-col></v-row>
                        <v-row align="center" justify="space-around" ><v-spacer></v-spacer><v-col cols="10"><p><?= $award->description ?></p></v-col><v-spacer></v-spacer></v-row>
                        <v-row align="center" justify="space-around"><button @click.prevent="selectAward( <?= $award->id ?> )" class="btn btn-secondary">Select Award</button></v-row></v-col>
                </v-row>
            </v-sheet>
        </v-carousel-item>
    <?php endforeach ?>
</v-carousel>
<div class="row" v-if="errorsStep2.length">
    <div class="col-3">
        &nbsp;
    </div>
    <div class="col-6">
        <v-alert type="error">There are errors.
            <ul>
                <li v-for="error in errorsStep2">{{error}}</li>
            </ul>
        </v-alert>
    </div>
    <div class="col-3"></div>
</div>
<!-- Award selection confirmation -->
<div class="row" v-if="selectedAward != -1">
    <div class="col-2"></div>

    <div class="col-8" style="text-align: center;">

        <h3 >You have selected your award : </h3>

                <?php foreach ($awardinfo as $award): ?>
                    <h3 v-if="selectedAward == <?= $award->id ?>"><?= $award->name ?></h3>
                <?php endforeach; ?>


        <div v-if="displayWatch || displayBracelet || displayPecsf">
            <p>Please enter additional customization information</p>
        </div>


    </div>
    <div class="col-2">

    </div>
</div>


<!-- WATCH CONTROLS -->
<div class="row" v-if="displayWatch">
    <div class="col-4">
        <div class="form-group">
            <label for="watch_size"> Watch Size:</label>
            <select class="form-control" name="watch_size" id="watch_size" v-model="watchSize">
                <option disabled selected>Select Watch Size</option>
                <option>38mm face with 20mm strap</option>
                <option>29mm face with 14mm strap</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="watch_colour">Watch Colour:</label>
            <select class="form-control" name="watch_colour" id="watch_colour" v-model="watchColour">
                <option disabled selected>Select a colour</option>
                <option>Gold</option>
                <option>Silver</option>
                <option>Two-Toned (Gold &amp; Silver)</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="strap_type">Strap:</label>
            <select  class="form-control" name="strap_type" id="strap_type" v-model="strapType">
                <option disabled selected>Choose Strap</option>
                <option>Plated</option>
                <option>Black Leather</option>
                <option>Brown Leather</option>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="watch_engraving">Engraving</label>
            <input class="form-control" type="text" name="watch_engraving" maxlength="33" :placeholder="firstName + ' ' + lastName" id="watch_engraving" v-model="watchEngraving">
        </div>
    </div>
</div>

<!-- 35 YR BRACELET CONTROLS -->
<div class="row" v-if="displayBracelet">
    <div class="form-group">
        <label for="bracelet_size">Size</label>
        <select  class="form-control" name="bracelet_size" id="bracelet_size" v-model="braceletSize">
            <option disabled selected>Choose Size</option>
            <option>Fits 6 ½″ - 7 ½″ circumference wrists</option>
            <option>Fits 7 ½″ - 8 ½″ circumference wrists</option>
        </select>
    </div>
</div>





    <!-- PECSF DONATION CONTROLS -->
    <div class="row" v-if="displayPecsf">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Name on Donation</label>
                <input class="form-control" type="text" maxlength="33" placeholder="Firstname Lastname" name="pecsf_name" id="pecsf_name_name" v-model="pecsfName">
            </div>
            <div  class="form-group">
                <label for="pecsf_region">Your Desired PECSF Region</label>
                <select class="form-control" name="pecsf_region" id="pecsf_region" v-model="pecsfRegion">
                        <option value="0" selected disabled>Please Select a Region</option>
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
                <select class="form-control"  v-if="donationType != 'pool'" name="pecsf_charity_1" id="pecsf_charity_1" v-model="pecsfCharity1">
                    <option selected disabled value="0">Choose a charity</option>
                    <?php foreach ($charities as $charity): ?>
                        <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id; ?>"><?= $charity->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group" v-if="donationType == 'two-charities'">
                <label for="pecsf_charity_2">Choose your second charity</label>
                <select class="form-control" name="pecsf_charity_2" id="pecsf_charity_2" v-model="pecsfCharity2">
                    <option selected disabled value="0">Choose a charity</option>
                    <?php foreach ($charities as $charity): ?>
                        <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id; ?>"><?= $charity->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>



    </div>
    <input type="hidden" name="award_id" id="award_id" v-model="selectedAward">
    <div class="row">
        <div class="col-3">
            <button class="btn btn-secondary" @click.prevent="e1 = 1">Back to Milestone</button>
        </div>
        <div class="col-5">

        </div>
        <div class="col-4">
            <button id="award-button" class="btn btn-primary" @click.prevent="validateStep2(); scrollToTop();" >Enter Contact Information</button>
        </div>
    </div>
