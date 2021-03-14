<h3 class="display-3">Your Contact Information</h3>
<div class="row" v-if="errorsStep3.length">
    <div class="col-3">
        &nbsp;
    </div>
    <div class="col-6">
        <v-alert type="error">There are errors.
            <ul>
                <li v-for="error in errorsStep3">{{error}}</li>
            </ul>
        </v-alert>
    </div>
    <div class="col-3"></div>
</div>
<div class="row">
    <div class="col-3">
        <div class="form-group">
            <label for="employee_id">Employee ID #</label>
            <input type="text" id="employee_id" name="employee_id" class="form-control" placeholder="123456" v-model="employeeID">
        </div>
    </div>
    <div class="col-3">
        <small>For our records are you a BCGEU member?</small>
        <div class="form-group checkbox-group">
            <input class="form-check-input" type="checkbox" name="member_bcgeu" id="member_bcgeu" value="1" v-model="isBcgeuMember" >
            <label class="form-check-label" for="member_bcgeu">Yes</label>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" v-model="firstName" class="form-control" placeholder="Your First Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" v-model="lastName" class="form-control" placeholder="Your Last Name">
        </div>
    </div>


    <div class="col-6">
        <div class="form-group isGovtEmailValid">
            <label for="preferred_email">Government email address</label>
            <input type="email" id="preferred_email" name="preferred_email" v-model="govtEmail" class="form-control email-input" placeholder="i.e. taylor.publicservant@gov.bc.ca" @change="isGovtEmailValid">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group isAltEmailValid">
            <label for="alternate_email">Alternate email address</label>
            <input type="email" id="alternate_email" name="alternate_email" v-model="altEmail" class="form-control email-input" placeholder="i.e. taylor_publicservant@gmail.com" @change="isAltEmailValid">
        </div>
    </div>


        <div class="col-6">
            <div class="form-group">
                <label for="">Current Ministry</label>
                <select name="ministry_id" id="ministry_id" class="form-control with-arrow" v-model="ministry" @change="setMinistryName">
                    <option selected default disabled>Select Ministry</option>
                    <?php foreach ($ministries as $ministry) :?>
                        <option value="<?= $ministry->id ?>"><?= $ministry->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Current branch</label>
                <input type="text" id="branch" name="branch" v-model="ministryBranch"
                       class="form-control" placeholder="i.e. Corporate Services">
            </div>
        </div>
</div>
<div class="row">
        <div class="col-12"><h4 class="display-2">Your Office Address</h4></div>

        <div class="col-4">
            <div class="form-group">
                <label for="">Floor/Room/Care Of</label>
                <input type="text" id="office_careof" name="office_careof" class="form-control" v-model="officeMailPrefix" placeholder="i.e. Discovery Room">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="">Suite</label>
                <input type="text"  id="office_suite" name="office_suite" class="form-control" v-model="officeSuite" placeholder="i.e. 800">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="">Street Address</label>
                <input type="text" class="form-control" id="office_address" name="office_address" v-model="officeStreetAddress" placeholder="i.e. 1445 10th Ave.">
            </div>
        </div>

        <div class="col-5">
            <div class="form-group">
                <label for="">City</label>
                <select name="office_city_id" id="office_city_id" class="form-control with-arrow" v-model="officeCity" @change="setOfficeCityName">
                    <option selected disabled>Choose city</option>
                    <?php foreach ($cities as $city) : ?>
                        <option value="<?= $city->id ?>"><?= h($city->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="">Postal Code</label>
                <input type="text" class="form-control"  id="office_postal_code" name="office_postal_code" placeholder="i.e. A1A 1A1" v-model="officePostalCode" @change="filterOfficePostalCode">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label for="">Office Phone Number</label>
                <input type="text" class="form-control" id="work_phone" name="work_phone" placeholder="i.e. (604) 555-5555" v-model="officePhone" @change="filterOfficePhoneNumber">
            </div>
        </div>
        <div class="col-2">
            <div clas="form-group">
                <label for="">Extension</label>
                <input type="text" class="form-control extension-input"  id="work_extension" name="work_extension" placeholder="ie. 800" v-model="officeExtension" @change="filterOfficeExtension">
            </div>
        </div>
</div>

<div class="row">
        <div class="col-12"><h4 class="display-2">Your Home Address</h4></div>
        <div class="col-4">
            <div class="form-group">
                <label for="home_suite">Suite</label>
                <input type="text" class="form-control" id="home_suite" name="home_suite" placeholder="i.e. 800" v-model="homeSuite">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="">Street Address</label>
                <input type="text" class="form-control" id="home_address" name="home_address" placeholder="i.e. 1445 10th Ave." v-model="homeStreetAddress">
            </div>
        </div>
        <div class="col-4"></div>

        <div class="col-6">
            <div class="form-group">
                <label for="">City</label>
                <select name="home_city_id" id="home_city_id" class="form-control with-arrow" v-model="homeCity" @change="setHomeCityName">
                    <option selected disabled>Choose city</option>
                    <?php foreach ($cities as $city) : ?>
                        <option value="<?= $city->id ?>"><?= h($city->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="">Postal Code</label>
                <input type="text" class="form-control" id="home_postal_code" name="home_postal_code" placeholder="i.e. A1A 1A1" v-model="homePostalCode" @change="filterHomePostalCode">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="">Home Phone Number</label>
                <input type="text" class="form-control" name="home_phone" id="home_phone" placeholder="i.e. (604) 555-5555" v-model="homePhone" @change="filterHomePhoneNumber">
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-3">
            <button class="btn btn-secondary" @click.prevent="e1 = 2">Back to Select Award</button>
        </div>
        <div class="col-5">

        </div>
        <div class="col-4">
            <button class="btn btn-primary" @click.prevent="validateStep3()">Enter Supervisor's Contact Info.</button>
        </div>
    </div>
