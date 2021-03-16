    <div class="form-group">
        <label for="">Name on Donation</label>
        <input class="form-control" type="text" maxlength="33" placeholder="Firstname Lastname" name="pecsf_name" id="pecsf_name_name" v-model="pecsfName">
    </div>
    <div  class="form-group">
        <label for="pecsf_region">Your Desired PECSF Region</label>
        <select class="form-control" name="pecsf_region" id="pecsf_region" v-model="pecsfRegion" @change="setPecsfRegionName">
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
        <select class="form-control"  v-if="donationType != 'pool'" name="pecsf_charity_1" id="pecsf_charity_1" v-model="pecsfCharity1" @change="setCharity1Name">
            <option selected disabled value="0">Choose a charity</option>
            <?php foreach ($charities as $charity): ?>
                <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id; ?>"><?= $charity->name ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-group" v-if="donationType == 'two-charities'">
        <label for="pecsf_charity_2">Choose your second charity</label>
        <select class="form-control" name="pecsf_charity_2" id="pecsf_charity_2" v-model="pecsfCharity2" @change="setCharity2Name">
            <option selected disabled value="0">Choose a charity</option>
            <?php foreach ($charities as $charity): ?>
                <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id; ?>"><?= $charity->name ?></option>
            <?php endforeach ?>
        </select>
    </div>
