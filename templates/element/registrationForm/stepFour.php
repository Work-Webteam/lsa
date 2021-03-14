<h3 class="display-3">Your Supervisor's Information</h3>
<div class="row" v-if="errorsStep4.length">
    <div class="col-3">
        &nbsp;
    </div>
    <div class="col-6">
        <v-alert type="error">There are errors.
            <ul>
                <li v-for="error in errorsStep4">{{error}}</li>
            </ul>
        </v-alert>
    </div>
    <div class="col-3"></div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="supervisorFirstName">Supervisor's First Name</label>
            <input type="text" class="form-control" id="supervisor_first_name" name="supervisor_first_name" placeholder="i.e. Taylor " v-model="supervisorFirstName">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="supervisorLastName">Supervisor's Last Name</label>
            <input type="text" class="form-control" id="supervisor_last_name" name="supervisor_last_name" placeholder="i.e. Publicservant" v-model="supervisorLastName">
        </div>
    </div>


    <div class="col-6">
        <div class="form-group isSupervisorEmailValid">
            <label for="supervisorEmail">Supervisor's Email</label>
            <input type="text" class="form-control email-input" id="supervisor_email" name="supervisor_email" placeholder="i.e. taylor.publicservant@gov.bc.ca" v-model="supervisorEmail" @change="isSupervisorEmailValid">
        </div>
    </div>
    <div class="col-6"></div>
    <div class="col-6">
            <div class="form-group">
                <label for="">Floor/Room/Care Of</label>
                <input type="text" class="form-control" id="supervisor_careof" name="supervisor_careof" placeholder="i.e. Discovery Room" v-model="supervisorMailPrefix">
            </div>
        </div>
    <div class="col-6">
        <div class="form-group">
                <label for="">Suite</label>
                <input type="text" class="form-control" id="supervisor_suite" name="supervisor_suite" placeholder="i.e. 800" v-model="supervisorSuite">
        </div>
    </div>

    <div class="col-12">
            <div class="form-group">
                <label for="">Street Address</label>
                <input type="text" class="form-control" id="supervisor_address" name="supervisor_address" placeholder="i.e. 1445 10th Ave." v-model="supervisorStreetAddress">
            </div>
        </div>
    <div class="col-8">
            <div class="form-group">
                <label for="">City</label>
                <select name="supervisor_city_id" id="supervisor_city_id" class="form-control with-arrow" v-model="supervisorCity" @change="setSupervisorCityName">
                    <option selected disabled value="0">Choose city</option>
                    <?php foreach ($cities as $city) : ?>
                        <option value="<?= $city->id ?>"><?= h($city->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
    </div>
    <div class="col-4">
        <div class="form-group">
                <label for="">Postal Code</label>
                <input type="text" class="form-control" id="supervisor_postal_code" name="supervisor_postal_code" placeholder="i.e. A1A 1A1" v-model="supervisorPostalCode" @change="filterSupervisorPostalCode">
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-3">

            <button class="btn btn-secondary" @click.prevent="e1 = 3">Back to Your Info</button>

        </div>
        <div class="col-5"></div>
        <div class="col-4">
            <button class="btn btn-primary" @click.prevent="validateStep4()">Confirm Info &amp; Agree to Terms</button>
        </div>
    </div>
