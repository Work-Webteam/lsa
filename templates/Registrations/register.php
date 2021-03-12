<?= $this->Form->create($registration) ?>

<div id="app">
    <template>
    <v-app>
        <v-main>
            <v-container class="grey lighten-2">
                <v-stepper v-model="e1">
                    <v-stepper-header id="carousel-top">
                        <v-stepper-step :complete="e1 > 1" step="1"> Milestone</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 2" step="2"> Award</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 3" step="3"> Contact <br> <span class="step-name-subtext">Employee</span>
                        </v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 4" step="4"> Contact <br> <span class="step-name-subtext">Supervisor</span>
                        </v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step :complete="e1 > 5" step="5"> Confirm</v-stepper-step>
                    </v-stepper-header>

                    <v-stepper-items>
                        <v-stepper-content class="grey lighten-3" step="1">
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
                            <div class="row">
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
                                        <input class="form-check-input" type="radio" name="retroactive" id="retroactive" value="1" v-model="isRetroactive" >
                                        <label class="form-check-label" for="retroactive">Yes</label>
                                    </div>
                                    <div class="form-group checkbox-group">
                                        <input class="form-check-input" type="radio" name="retroactive" id="retroactive" checked value="0" v-model="isRetroactive">
                                        <label class="form-check-label" for="retroactive">No</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <p>Are you retiring this calendar year? </p>
                                        <div class="form-group checkbox-group">
                                            <input class="form-check-input" type="radio" name="retiring_this_year" id="retiring_this_year" value="1"
                                                   v-model="isRetiringThisYear">
                                            <label class="form-check-label" for="retiring_this_year">Yes</label>
                                        </div>
                                        <div class="form-group checkbox-group">
                                            <input class="form-check-input" type="radio" name="retiring_this_year" id="retiring_this_year" value="0"
                                                   checked v-model="isRetiringThisYear">
                                            <label class="form-check-label" for="retiring_this_year">No</label>
                                        </div>

                                        <div class="form-group" v-if="isRetiringThisYear == 1">
                                            <label for="retirement_date">Date of Retirement:</label>
                                            <input type="date" class="form-control" name="retirement_date" id="retirement_date" v-model="retirementDate" min="2021-01-01" max="2021-12-31">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3" v-if="isRetroactive == 1">
                                    <p>Did you receive your award?</p>
                                    <div class="form-group checkbox-group">
                                        <input class="form-check-input" type="radio" name="award_received" id="award_received" value="1" v-model="awardReceived" >
                                        <label class="form-check-label" for="award_received">Yes</label>
                                    </div>
                                    <div class="form-group checkbox-group">
                                        <input class="form-check-input" type="radio" name="award_received" id="award_received" checked value="0" v-model="awardReceived">
                                        <label class="form-check-label" for="award_received">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-10"></div>
                                <div class="col-2"><button class="btn btn-primary" @click.prevent="validateStep1()">Select Award</button></div>
                            </div>

                        </v-stepper-content>




                        <v-stepper-content class="grey lighten-3" step="2">
                            <h3 class="display-3">Select Your Award</h3>
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
                            <!-- Award selection confirmation -->
                            <div class="row" v-if="selectedAward != -1">
                                <div class="col-4"></div>

                               <div class="col-4">
                                   <div class="form-group">
                                       <h3 class="">You have selected your award.</h3>
                                   </div>
                               </div>
                                <div class="col-4">

                                </div>
                            </div>

                            <!-- WATCH CONTROLS -->
                            <div class="row" v-if="selectedAward == 9">
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
                                            <option disabled selected></option>
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
                            <div class="row" v-if="selectedAward == 12">
                                <div class="col-4">
                                <div class="form-group">
                                    <label for="bracelet_size">Size</label>
                                    <select  class="form-control" name="bracelet_size" id="bracelet_size" v-model="braceletSize">
                                        <option disabled selected>Choose Size</option>
                                        <option>Fits 6 ½″ - 7 ½″ circumference wrists</option>
                                        <option>Fits 7 ½″ - 8 ½″ circumference wrists</option>
                                    </select>
                                </div>
                                </div>
                                <div class="col-8"></div>
                            </div>

                            <!-- 45 YR BRACELET CONTROLS -->
                            <div class="row" v-if="selectedAward == 46">
                                <div class="form-group">
                                    <label for="bracelet_size">Size</label>
                                    <select class="form-control" name="bracelet_size" id="bracelet_size" v-model="braceletSize">
                                        <option disabled selected>Choose Size</option>
                                        <option>Fits 6 ½″ - 7 ½″ circumference wrists</option>
                                        <option>Fits 7 ½″ - 8 ½″ circumference wrists</option>
                                    </select>
                                </div>
                            </div>

                            <!-- PECSF DONATION CONTROLS -->
                            <div class="row" v-if="selectedAward == 49 || selectedAward == 50 || selectedAward == 51 || selectedAward == 52 || selectedAward == 53 || selectedAward == 54">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Name on Donation</label>
                                        <input class="form-control" type="text" maxlength="33" placeholder="Firstname Lastname" name="pecsf_name" id="pecsf_name_name" v-model="pecsfName">
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
                                        <select class="form-control"  v-if="donationType != 'pool'" name="pecsf_charity_1" id="pecsf_charity_1" v-model="pecsfCharity1">
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
                            <input type="hidden" name="award_id" id="award_id" v-model="selectedAward">
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-secondary" @click.prevent="e1 = 1">Back to Milestone</button>
                                </div>
                                <div class="col-6">

                                </div>
                                <div class="col-3">
                                    <button id="award-button" class="btn btn-primary" @click.prevent="validateStep2(); scrollToTop();" >Enter Contact Information</button>
                                </div>
                            </div>


                        </v-stepper-content>


                        <v-stepper-content class="grey lighten-3" step="3">
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
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="employee_id">Employee ID #</label>
                                        <input type="text" id="employee_id" name="employee_id" class="form-control" placeholder="123456" v-model="employeeID">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="member_bcgeu">For our records, please indicate if you are a member of the BGCEU.</label>
                                        <input type="checkbox" id="member_bcgeu" name="member_bcgeu" class="form-control" v-model="isBcgeuMember">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" id="first_name" name="first_name" v-model="firstName" class="form-control" placeholder="Your First Name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" v-model="lastName" class="form-control" placeholder="Your Last Name">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6">
                                    <div class="[form-group, isGovtEmailValid]">
                                        <label for="preferred_email">Government email address</label>
                                        <input type="email" id="preferred_email" name="preferred_email" v-model="govtEmail" class="form-control email-input" placeholder="i.e. taylor.publicservant@gov.bc.ca" @change="isGovtEmailValid">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="[form-group, isAltEmailValid]">
                                        <label for="alternate_email">Alternate email address</label>
                                        <input type="email" id="alternate_email" name="alternate_email" v-model="altEmail" class="form-control email-input" placeholder="i.e. taylor_publicservant@gmail.com" @change="isAltEmailValid">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                                <h4 class="display-2">Your Office Address</h4>
                            </div>
                            <div class="row">
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
                            </div>


                            <div class="row">
                                <div class="col-6">
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
                                <div class="col-1">
                                    <div clas="form-group">
                                        <label for="">Extension</label>
                                        <input type="text" class="form-control extension-input"  id="work_extension" name="work_extension" placeholder="ie. 800" v-model="officeExtension" @change="filterOfficeExtension">
                                    </div>
                                </div>
                            </div>
                            <h4 class="display-2">Your Home Address</h4>
                            <div class="row">
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
                            </div>

                           <div class="row">

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
                                <div class="col-6">

                                </div>
                                <div class="col-3">
                                    <button class="btn btn-primary" @click.prevent="validateStep3()">Enter Supervisor's Contact Info.</button>
                                </div>
                            </div>


                        </v-stepper-content>

                        <v-stepper-content class="grey lighten-3" step="4">
                            <h3 class="display-3">Your Supervisor's Contact Information</h3>
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
                            </div>
                            <div class="row">

                                <div class="col-6">
                                    <div class="[form-group, isSupervisorEmailValid]">
                                        <label for="supervisorEmail">Supervisor's Email</label>
                                        <input type="text" class="form-control email-input" id="supervisor_email" name="supervisor_email" placeholder="i.e. taylor.publicservant@gov.bc.ca" v-model="supervisorEmail" @change="isSupervisorEmailValid">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Street Address</label>
                                        <input type="text" class="form-control" id="supervisor_address" name="supervisor_address" placeholder="i.e. 1445 10th Ave." v-model="supervisorStreetAddress">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <select name="supervisor_city_id" id="supervisor_city_id" class="form-control with-arrow" v-model="supervisorCity" @change="setSupervisorCityName">
                                            <option selected disabled>Choose city</option>
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
                                <div class="col-6"></div>
                                <div class="col-3">
                                    <button class="btn btn-primary" @click.prevent="validateStep4()">Confirm Info &amp; Agree to Terms</button>
                                </div>
                            </div>



                        </v-stepper-content>

                        <v-stepper-content class="grey lighten-3" step="5">
                            <h3 class="display-3">Confirm Your Information</h3>
                            <div class="confirmationGroup grey lighten-2">
                                <h4>Milestone</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <p><small>Milestone reached:</small></p>
                                        <p class="confirmationValue">{{milestoneName}}</p>
                                    </div>
                                    <div class="col-6" v-if="milestone == 1">
                                        <p><small>Name on certificate</small></p>
                                        <p class="confirmationValue">{{certificateName}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p v-if="isBcgeuMember" class="confirmationValue">I am a BCGEU Member</p>
                                    </div>
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
                                <div class="row">
                                    <div class="col-9">

                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-secondary" @click.prevent="e1 = 1">Edit this Section</button>
                                    </div>
                                </div>

                            </div>
                            <div class="confirmationGroup grey lighten-2">
                                <h4>Award &amp; Options</h4>

                                <?php foreach ($awardinfo as $award): ?>
                                    <div class="row" v-if="selectedAward == <?= $award->id ?>">
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
                                            <p class="confirmationValue">Retroactive</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-9">
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-secondary" @click.prevent="e1 = 2">Edit this Section</button>
                                    </div>
                                </div>
                            </div>
                            <div class="confirmationGroup grey lighten-2">
                                <h4>Your Contact Information</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <p><small>Your Name</small></p>
                                        <p class="confirmationValue">{{firstName}} {{lastName}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><small>Your Employee ID #</small></p>
                                        <p class="confirmationValue">{{employeeID}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p><small>Your Government email address</small></p>
                                        <p class="confirmationValue">{{govtEmail}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><small>Your alternate email address</small></p>
                                        <p class="confirmationValue">{{altEmail}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <p><small>Your current Ministry</small></p>
                                        <p class="confirmationValue">{{ministryName}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><small>Your current branch</small></p>
                                        <p class="confirmationValue">{{ministryBranch}}</p>
                                    </div>
                                </div>
                                <div class="row">
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
                                <div class="row">
                                        <div class="col-9"></div>
                                        <div class="col-3"><button class="btn btn-secondary" @click.prevent="e1 = 3">Edit this Section</button></div>
                                </div>
                            </div>

                            <div class="confirmationGroup grey lighten-2">
                                <h4>Your Supervisor&apos;s Contact Information</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <p><small>Supervisor&apos;s Name</small></p>
                                        <p class="confirmationValue">{{supervisorFirstName}} {{supervisorLastName}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><small>Supervisor&apos;s Email</small></p>
                                        <p class="confirmationValue">{{supervisorEmail}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p><small>Supervisor&apos;s Office Address</small></p>
                                        <p class="confirmationValue">{{supervisorMailPrefix}}</p>
                                        <p class="confirmationValue">{{supervisorSuite}} {{supervisorStreetAddress}}</p>
                                        <p class="confirmationValue">{{supervisorCityName}}, BC</p>
                                        <p class="confirmationValue">{{supervisorPostalCode}}</p>
                                    </div>
                                    <div class="col-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-3"><button class="btn btn-secondary" @click.prevent="e1 = 4">Edit this Section</button></div>
                                </div>
                            </div>


                            <div class="confirmationGroup grey lighten-2">
                                <h4>Survey Participation &amp; Consent</h4>
                                <div class="row">
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
                                <div class="row">
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
                                <div class="row">
                                    <div class="col-3">
                                        <button class="btn btn-secondary" @click.prevent="e1 = 4">Back to Supervisor Info</button>
                                    </div>
                                    <div class="col-6">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary" :disabled="isDeclared == false">Submit Registration</button>
                                    </div>
                                </div>


                        </v-stepper-content>


                    </v-stepper-items>

                </v-stepper>
            </v-container>
        </v-main>
    </v-app>
</template>
</div>
<?= $this->Form->end(); ?>


<!-- Registration Form-specific JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js" integrity="sha512-VpQwrlvKqJHKtIvpL8Zv6819FkTJyE1DoVNH0L2RLn8hUPjRjkS/bCYurZs0DX9Ybwu9oHRHdBZR9fESaq8Z8A==" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

<script src="/js/registration/registration-info.js"></script>

<script>

    Vue.config.devtools = true;



</script>

