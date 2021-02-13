<?= $this->Form->create($registration) ?>

<div id="app">
    <template>
    <v-app>
        <v-main>
            <v-container class="grey lighten-2">
                <v-stepper v-model="e1">
                    <v-stepper-header>
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
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="milestone">Which milestone are you celebrating?</label>
                                        <select class="form-control with-arrow" id="milestone_id" name="milestone_id" v-model="milestone">
                                            <option selected disabled>Select Milestone</option>
                                            <?php foreach ($milestoneinfo as $mstone) : ?>
                                                <option value="<?= $mstone->id ?>"><?= $mstone->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">In which year did you reach this milestone?</label>
                                        <select class="form-control with-arrow" id="award_year" name="award_year" v-model="award_year">
                                            <option selected disabled>Select Year</option>

                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                                <option value="2019">2019</option>

                                            <option disabled>──────────</option>

                                                <?php foreach ($award_years as $ayear) : ?>
                                                    <option value="<?= $ayear ?>"><?= $ayear ?></option>
                                                <?php endforeach ?>

                                        </select>


                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group" v-if="milestone == 1">
                                        <label for="">How would you like your name to appear on your certificate?</label>
                                        <input type="text" id="certificateName" name="certificate_name" v-model="certificateName" class="form-control">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <p>Did you register for a Long Service Award in 2019?</p>
                                    <div class="form-group checkbox-group">
                                        <input class="form-check-input" type="radio" name="retroactive" id="retroactive" value="1">
                                        <label class="form-check-label" for="retroactive">Yes</label>
                                    </div>
                                    <div class="form-group checkbox-group">
                                        <input class="form-check-input" type="radio" name="retroactive" id="retroactive" checked value="0">
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
                                            <input type="date" name="retirement_date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary" @click.prevent="validateStep1()">Select Award</button>
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
                            <v-carousel v-on:change="highlightedAward = servicesCarouselItems[$event].awardid">
                                <?php foreach ($awardinfo as $award): ?>
                                    <v-carousel-item awardID="<?= $award->id ?>" v-if="milestone == <?= $award->milestone_id ?>">
                                        <v-sheet height="100%" tile>
                                            <v-row>
                                                <v-col><v-img src="/img/awards/<?= $award->image ?>"></v-img></v-col>
                                                <v-col>
                                                    <v-row align="center" justify="center"><h3 class="display-3 award-title"><?= $award->name ?></h3></v-row>
                                                    <v-row align="center" justify="center" ><v-spacer></v-spacer><v-col cols="8"><p><?= $award->description ?></p></v-col><v-spacer></v-spacer></v-row>
                                                    <v-row align="center" justify="center"><button @click.prevent="selectAward( <?= $award->id ?> )" class="btn btn-secondary">Select Award</button></v-row></v-col>
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
                                        <label for=""> Watch Size:</label>
                                        <select class="form-control" name="" id="">
                                            <option disabled selected>Select Watch Size</option>
                                            <option>38mm face with 20mm strap</option>
                                            <option>29mm face with 14mm strap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Watch Colour:</label>
                                        <select class="form-control" name="" id="">
                                            <option disabled selected></option>
                                            <option>Gold</option>
                                            <option>Silver</option>
                                            <option>Two-Toned (Gold &amp;s Silver)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Strap:</label>
                                        <select  class="form-control" name="" id="">
                                            <option disabled selected>Choose Strap</option>
                                            <option>Plated</option>
                                            <option>Black Leather</option>
                                            <option>Brown Leather</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Engraving</label>
                                        <input class="form-control" type="text" name="engraving" maxlength="33" :placeholder="firstName + ' ' + lastName">
                                    </div>
                                </div>
                            </div>

                            <!-- 35 YR BRACELET CONTROLS -->
                            <div class="row" v-if="selectedAward == 12">
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <select  class="form-control" name="" id="">
                                        <option disabled selected>Choose Size</option>
                                        <option>Fits 6 1/2" - 7 1/2" circumference wrists</option>
                                        <option>Fits 7 1/2" - 8 1/2" circumference wrists</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 45 YR BRACELET CONTROLS -->
                            <div class="row" v-if="selectedAward == 46">
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <select class="form-control" name="" id="">
                                        <option disabled selected>Choose Size</option>
                                        <option>Fits 6 1/2" - 7 1/2" circumference wrists</option>
                                        <option>Fits 7 1/2" - 8 1/2" circumference wrists</option>
                                    </select>
                                </div>
                            </div>

                            <!-- PECSF DONATION CONTROLS -->
                            <div class="row" v-if="selectedAward == 49 || selectedAward == 50 || selectedAward == 51 || selectedAward == 52 || selectedAward == 53 || selectedAward == 54">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Name on Donation</label>
                                        <input class="form-control" type="text" maxlength="33" placeholder="Firstname Lastname" :value="firstName + ' ' + lastName">
                                    </div>
                                    <div  class="form-group">
                                        <label for="">Your Desired PECSF Region</label>
                                        <select class="form-control" name="" id="" v-model="pecsfRegion">
                                            <?php foreach ($regions as $region) : ?>
                                            <option value="<?= $region->id ?>"><?= $region->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="" id="" value="pool" v-model="donationType" checked>
                                        <label class="form-check-label" for="">Donate to the fund-supported pool for my chosen region</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="" id="" value="single-charity" v-model="donationType">
                                        <label class="form-check-label" for="">Donate to a specific charity</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="" id="" value="two-charities" v-model="donationType">
                                        <label class="form-check-label" for="">Donate to two charities</label>
                                    </div>
                                    <div class="form-group" >
                                        <label for="" v-if="donationType == 'single-charity'">Choose your charity</label>
                                        <label for="" v-if="donationType == 'two-charities'">Choose your first charity</label>
                                        <select class="form-control"  name="" id="" v-model="pecsfCharity1">
                                            <option selected disabled>Choose a charity</option>
                                            <?php foreach ($charities as $charity): ?>
                                            <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id ?>"><?= $charity->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group" v-if="donationType == 'two-charities'">
                                        <label for="">Choose your second charity</label>
                                        <select class="form-control" name="" id="" v-model="pecsfCharity1">
                                            <option selected disabled>Choose a charity</option>
                                            <?php foreach ($charities as $charity): ?>
                                                <option value="<?= $charity->id ?>" v-if="pecsfRegion == <?= $charity->pecsf_region_id ?>"><?= $charity->name ?></option>
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
                                    <button id="award-button" class="btn btn-primary" @click.prevent="validateStep2()">Enter Contact Information</button>
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
                            <div class="form-row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Employee ID #</label>
                                        <input type="text" id="employee_id" name="employee_id" class="form-control" placeholder="123456" v-model="employeeID">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" id="first_name" name="first_name" v-model="firstName" class="form-control" placeholder="Your First Name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" v-model="lastName" class="form-control" placeholder="Your Last Name">
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Government email address</label>
                                        <input type="email" id="preferred_email" name="preferred_email" v-model="govtEmail" class="form-control email-input" placeholder="i.e. taylor.publicservant@gov.bc.ca">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Alternate email address</label>
                                        <input type="email" id="alternate_email" name="alternate_email" v-model="altEmail" class="form-control email-input" placeholder="i.e. taylor_publicservant@gmail.com">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Current Ministry</label>
                                        <select name="ministry_id" id="ministry_id" class="form-control with-arrow" v-model="ministry">
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

                            <div class="form-row">
                                <h4 class="display-2">Your Office Address</h4>
                            </div>
                            <div class="form-row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Floor/Room/Care Of</label>
                                        <input type="text" id="office_careof" name="office_careof" class="form-control" placeholder="i.e. Discovery Room">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Suite</label>
                                        <input type="text"  id="office_suite" name="office_suite" class="form-control" placeholder="i.e. 800">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Street Address</label>
                                        <input type="text" class="form-control" id="office_address" name="office_address" placeholder="i.e. 1445 10th Ave.">
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <select name="office_city_id" id="office_city_id" class="form-control with-arrow" v-model="officeCity">
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
                                        <input type="text" class="form-control postal-code-input"  id="office_postal_code" name="office_postal_code" placeholder="i.e. A1A 1A1">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="">Office Phone Number</label>
                                        <input type="text" class="form-control phone-input" id="work_phone" name="work_phone" placeholder="i.e. (604) 555-5555" v-model="officePhone">
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div clas="form-group">
                                        <label for="">Extension</label>
                                        <input type="text" class="form-control"  id="work_extension" name="work_extension" placeholder="ie. 800" v-model="officeExtension">
                                    </div>
                                </div>
                            </div>
                            <h4 class="display-2">Your Home Address</h4>
                            <div class="form-row">
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

                           <div class="form-row">

                               <div class="col-6">
                                   <div class="form-group">
                                       <label for="">City</label>
                                       <select name="home_city_id" id="home_city_id" class="form-control with-arrow" v-model="homeCity">
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
                                       <input type="text" class="form-control postal-code-input" id="home_postal_code" name="home_postal_code" placeholder="i.e. A1A 1A1" v-model="homePostalCode">
                                   </div>
                               </div>
                               <div class="col-4">
                                   <div class="form-group">
                                       <label for="">Home Phone Number</label>
                                       <input type="text" class="form-control phone-input" name="home_phone" id="home_phone" placeholder="i.e. (604) 555-5555" v-model="homePhone">
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
                            <div class="form-row">
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
                            <div class="form-row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="supervisorEmail">Supervisor's Email</label>
                                        <input type="text" class="form-control email-input" id="supervisor_email" name="supervisor_email" placeholder="i.e. taylor.publicservant@gov.bc.ca" v-model="supervisorEmail">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
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
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Street Address</label>
                                        <input type="text" class="form-control" id="supervisor_address" name="supervisor_address" placeholder="i.e. 1445 10th Ave." v-model="supervisorStreetAddress">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <select name="supervisor_city_id" id="supervisor_city_id" class="form-control with-arrow" v-model="supervisorCity">
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
                                        <input type="text" class="form-control postal-code-input" id="supervisor_postal_code" name="supervisor_postal_code" placeholder="i.e. A1A 1A1" v-model="supervisorPostalCode">
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
                                <div class="form-row">
                                    <div class="col-6">
                                        <p><small>Milestone reached:</small></p>
                                        <p class="confirmationValue">{{milestone}}</p>
                                    </div>
                                    <div class="col-6">
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
                                        <p v-if="pastRegistrationNoCeremony" class="confirmation-label">I registered last year but did not attended</p>
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
                                    <div class="col-6">
                                        <p><small>Your Employee ID #</small></p>
                                        <p class="confirmationValue">{{employeeID}}</p>
                                    </div>
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
                                        <p class="confirmationValue">{{ministry}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><small>Your current branch</small></p>
                                        <p class="confirmationValue">{{ministryBranch}}</p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-6">
                                        <p><small>Your Office Address</small></p>
                                        <p class="confirmationValue">{{officeMailPrefix}}</p>
                                        <p class="confirmationValue">{{officeSuite}} {{officeStreetAddress}}</p>
                                        <p class="confirmationValue">{{officeCity}}, BC</p>
                                        <p class="confirmationValue">{{officePostalCode}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p><small>Your Home Address</small></p>
                                        <p class="confirmationValue">{{homeSuite}}</p>
                                        <p class="confirmationValue">{{homeStreetAddress}}</p>
                                        <p class="confirmationValue">{{homeCity}}</p>
                                        <p class="confirmationValue">{{homePostalCode}}</p>
                                    </div>
                                </div>
                                <div class="form-row">
                                        <div class="col-9"></div>
                                        <div class="col-3"><button class="btn btn-secondary" @click="e1 = 3">Edit this Section</button></div>
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
                                        <p class="confirmationValue">{{supervisorCity}}, BC</p>
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
                                            <input class="form-check-input" type="checkbox" value="" id="">
                                            <label class="form-check-label" for="">
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
                                            <input class="form-check-input" type="checkbox" value="" id="" checked>
                                            <label class="form-check-label" for="">
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
                                        <button type="submit" class="btn btn-primary">Confirm &amp; Agree</button>
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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous"
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js" integrity="sha512-VpQwrlvKqJHKtIvpL8Zv6819FkTJyE1DoVNH0L2RLn8hUPjRjkS/bCYurZs0DX9Ybwu9oHRHdBZR9fESaq8Z8A==" crossorigin="anonymous"></script><!-- Special JavaScript just for Registration form -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>


<script>
    var app = new Vue({
        el: "#app",
        vuetify: new Vuetify(),
        data: {
            e1: 1,
            isRetiringThisYear: 0,
            milestone: 'Select Milestone',
            award_year: 'Select Year',

            employeeID: '',
            firstName: '',
            lastName: '',
            ministry: 'Select Ministry',
            ministryBranch: '',
            certificateName: '',

            pastRegistrationNoCeremony: '',

            govtEmail: '',
            altEmail: '',

            officeMailPrefix: '',
            officeSuite: '',
            officeStreetAddress: '',
            officeCity: 'Select A City',
            officePostalCode: '',
            officePhone: '',
            officeExtension: '',

            homeMailPrefix: '',
            homeSuite: '',
            homeStreetAddress: '',
            homeCity: 'Select A City',
            homePostalCode: '',
            homePhone: '',

            supervisorFirstName: '',
            supervisorLastName: '',
            supervisorMailPrefix: '',
            supervisorSuite: '',
            supervisorStreetAddress: '',
            supervisorCity: 'Select A City',
            supervisorPostalCode: '',
            supervisorEmail: '',
            supervisorPhone: '',
            supervisorExtension: '',

            availableAwards: '',
            availableAwardOptions: '',

            currentAwardName: '',
            currentAwardImage: '',
            currentAwardDescription: '',
            currentAwardIndex: 0,
            currentAwards: [],

        selectedAward: -1,
            awardName: '',
            awardDescription: '',
            awardOptions: [],
            awardImage: '',

            availableCharities: [],
            donationRegion: '',
            donationCharity1: '',
            donationCharity2: '',

            errorsStep1: [],
            errorsStep2: [],
            errorsStep3: [],
            errorsStep4: [],

            awardSelected: false,
            awardConfirmed: false,
            identifyingInfoInput: false,
            officeAddressInput: false,
            homeAddressInput: false,
            supervisorInput: false,
            informationConfirmed: false,
            showOptions: true,

            inputDonationType: false,
            inputCharity1: false,
            inputCharity2: false,
            testShow: false,

            pecsfRegion: 0,
            donationType: false,
            highlightedAward: 1
        },

        methods: {


            selectAward: function(awardid) {
                this.selectedAward = awardid;
                this.$vuetify.goTo('#award-button');
            },
            /*
            getCharity: function (select_id) {
                charity = 0;
                for (var i = 0; i < allCharities.length; i++) {
                    if (allCharities[i].id == select_id) {
                        charity = allCharities[i];
                    }
                }
                return charity;
            },

            selectCharityOptions: function () {
                $("#donation-1").modal('show');
                this.selectedAward = 0;
            },

            regionSelected: function () {
                this.donationRegion = $('#selectedregion :selected').text();

                this.availableCharities = [];
                for (var i = 0; i < allCharities.length; i++) {
                    if (allCharities[i].pecsf_region_id == $('#selectedregion').val()) {
                        this.availableCharities.push(allCharities[i]);
                    }
                }
                this.inputDonationType = true;
            },

            donationTypeSelected: function () {
                if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
                    this.inputCharity1 = false;
                    this.inputCharity2 = false;
                } else if ($("input:radio[name ='selectDonationType']:checked").val() == 1) {
                    this.inputCharity1 = true;
                    this.inputCharity2 = false;
                } else if ($("input:radio[name ='selectDonationType']:checked").val() == 2) {
                    this.inputCharity1 = true;
                    this.inputCharity2 = true;
                }
            },
            */
            validateStep1 : function () {
                this.errorsStep1 = [];
                //Did they put in a milestone year?
                if (this.milestone == 'Select Milestone') {
                    this.errorsStep1.push('You must select a milestone.');
                }
                //Did they indicate a qualifying year?
                if (this.award_year == 0) {
                    this.errorsStep1.push('You must select a qualifying year.');
                }

                if (this.errorsStep1.length == 0) {
                    this.e1 = 2;
                }

            },
            validateStep2 : function () {
                this.errorsStep2 = [];
                //Did they select an award?
                if (this.selectedAward == -1) {
                    this.errorsStep2.push('You must select an award');
                }

                //Did they indicate an award that requires options?


                if (this.errorsStep2.length == 0) {
                    this.e1 = 3;
                }
            },
            validateStep3 : function () {
               //Did include an employee number?
                if (this.employeeID.length < 5 || this.employeeID.length > 10) {
                    this.errorsStep3.push('You must input a valid employee number');
                }
               //Did they include their first name?
                if (this.firstName.length < 2 || this.firstName.length > 50) {
                    this.errorsStep3.push('You must input your first name.');
                }
               //Did they include their last name?
                if (this.lastName.length < 2 || this.lastName.length > 50) {
                    this.errorsStep3.push('You must input your last name');
                }
               //Did they include their gov email address?
                if (this.govtEmail.length < 6 ) {
                    this.errorsStep3.push('You must input your government email address');
                }
               //Did they specify their ministry?
                if (this.ministry == 'Select Ministry') {
                    this.errorsStep3.push('You must select your ministry');
                }
               //Did they indicate their current branch?
                if (this.ministryBranch == '') {
                    this.errorsStep3.push('You must input your branch');
                }
               //Did they include an office street address?
                if (this.officeStreetAddress.length < 4) {
                    this.errorsStep3.push('You must input your office address');
                }
               //Did they include an office city?
                if (this.officeCity == 'Select A City') {
                    this.errorsStep3.push('You must select your office city');
                }
               //Did they include a postal code?
                if (this.officePostalCode.length != 7) {
                    this.errorsStep3.push('You must input your office postal code');
                }
               //Did they include a phone number?
                if (this.officePhone.length != 13) {
                    this.errorsStep3.push('You must input your office phone number');
                }
               //Did they include a home street address?
                if (this.homeStreetAddress.length < 4) {
                    this.errorsStep3.push('You must input your home address');
                }
               //Did they include a home city?
                if (this.homeCity == 'Select A City') {
                    this.errorsStep3.push('You must input your home city');
                }
               //Did they include a home postal code?
                if (this.homePostalCode.length != 7) {
                    this.errorsStep3.push('You must input your home postal code');
                }
               //Did they include a home phone number?
                if (this.homePhone.length != 13) {
                    this.errorsStep3.push('You must input your home phone number');
                }

                if (this.errorsStep3.length == 0) {
                    this.e1 = 4;
                }
            },
            validateStep4 : function () {
                this.errorsStep4 = [];
                //Did they include a supervisor first name
                if (this.supervisorFirstName.length < 2 || this.supervisorFirstName.length > 50) {
                    this.errorsStep4.push('You must input your supervisor\'s first name');
                }
                //Did they include a supervisor surname
                if (this.supervisorLastName.length < 2 || this.supervisorLastName.length > 50) {
                    this.errorsStep4.push('You must input your supervisor\'s last name')
                }
                //Did they include a supervisor email
                if (this.supervisorEmail.length < 6) {
                    this.errorsStep4.push('You must input your supervisor\'s government email address');
                }
                //Did they include a supervisor street address
                if (this.supervisorStreetAddress.length < 4) {
                    this.errorsStep4.push('You must input your supervisor\'s office address');
                }
                //Did they include a supervisor city
                if (this.supervisorCity == 'Select A City') {
                    this.errorsStep4.push('You must input your supervisor\'s office city');
                }
                //Did they include a supervisor postal code
                if (this.supervisorPostalCode.length != 7) {
                    this.errorsStep4.push('You must input your supervisor\'s office postal code')
                }

                if (this.errorsStep4.lenght == 0) {
                    this.e1 = 5;
                }
            },

            selectAwardOptions: function (select_id) {
                award = this.getAward(select_id);

                options = JSON.parse(award.options);
                if (options.length > 0) {
                    if (this.selectedAward != award.id) {
                        jQuery('#formAwardOptions').empty();

                        availableOptions = "";
                        options.forEach((element, index, array) => {
                            availableOptions += "<p>" + element.name + "</p>";
                            if (element.type == "choice") {
                                input = '<label for="award-option-' + index + '">' + element.name + '</label>';
                                input += '<select id="award-option-' + index + '" requires="required">';
                                input += '<option value>- select option -</option>';

                                for (var i = 0; i < element.values.length; i++) {
                                    optionValue = element.values[i];
                                    input += '<option value="' + i + '">' + element.values[i] + '</option>';
                                }

                                input += '</select>';
                                jQuery('#formAwardOptions').append(input);
                            }
                            if (element.type == "text") {
                                input = '<label for="award-option-' + index + '">' + element.name + '</label>';
                                input += '<input type="text" id="award-option-' + index + '">';
                                jQuery('#formAwardOptions').append(input);
                            }
                        });
                    }
                    $("#awardName").html(award.name);
                    $("#award-1").modal('show');
                }
                this.selectedAward = award.id;
            },

            processOptions: function () {
                if (this.selectedAward == 0) {
                    this.processDonationOptions();
                } else {
                    this.processAwardOptions();
                }
            },

            processDonationOptions: function () {

                for (var i = 0; i < milestones.length; i++) {
                    if (milestones[i].id == $('#milestone-id').val()) {
                        milestone = milestones[i];
                    }
                }

                errors = [];

                $('input[name=pecsf_donation]').val(1);


                $('input[name=pecsf_name]').val($('input[name=donorName').val());

                this.awardOptions = [];
                $('#donation-type').css("border-color", clrDefault);
                if ($("input:radio[name ='selectDonationType']:checked").val() == 0) {
                    amount = milestone.donation;
                    this.awardOptions.push(this.currencyFormat(amount) + " Donation - PECSF Region Charity Fund");
                    $('input[name=pecsf_amount1]').val(amount);
                    $('input[name=pecsf_donation_type]').val(0);
                } else if ($("input:radio[name ='selectDonationType']:checked").val() == 1) {
                    if ($('#selectedCharity1').val() == 0) {
                        errors.push("Charity is required");
                        $('#selectedCharity1').css("border-color", clrError);
                    } else {
                        amount = milestone.donation;
                        charity = this.getCharity($('#selectedCharity1').val());
                        this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") " + charity.name);
                        $('#selectedCharity1').css("border-color", clrDefault);
                        $('input[name=pecsf_charity1_id]').val(charity.id);
                        $('input[name=pecsf_amount1]').val(amount);
                    }
                    $('input[name=pecsf_donation_type]').val(1);
                } else if ($("input:radio[name ='selectDonationType']:checked").val() == 2) {
                    amount = milestone.donation / 2;

                    if ($('#selectedCharity1').val() == 0) {
                        errors.push("First Charity is required");
                        $('#selectedCharity1').css("border-color", clrError);
                    } else {
                        charity = this.getCharity($('#selectedCharity1').val());
                        this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") " + charity.name);
                        $('#selectedCharity1').css("border-color", clrDefault);
                        $('input[name=pecsf_charity1_id]').val(charity.id);
                        $('input[name=pecsf_amount1]').val(amount);
                    }

                    if ($('#selectedCharity2').val() == 0) {
                        errors.push("Second Charity is required");
                        $('#selectedCharity2').css("border-color", clrError);
                    } else {
                        charity = this.getCharity($('#selectedCharity2').val());
                        this.awardOptions.push(this.currencyFormat(amount) + " Donation - (" + charity.vendor_code + ") " + charity.name);
                        $('#selectedCharity2').css("border-color", clrDefault);
                        $('input[name=pecsf_charity2_id]').val(charity.id);
                        $('input[name=pecsf_amount2]').val(amount);
                    }
                    $('input[name=pecsf_donation_type]').val(2);
                } else {
                    if (this.inputDonationType) {
                        errors.push('Please select the type of donation.');
                        $('#donation-type').css("border-color", clrError);
                    }
                }

                if (document.getElementById("selectedregion").selectedIndex == 0) {
                    errors.push('Region is required');
                    $('#selectedregion').css("border-color", clrError);
                } else {
                    $('#selectedregion').css("border-color", clrDefault);
                    $('input[name=pecsf_region_id]').val($('#selectedregion').val());
                }

                if (errors.length == 0) {
                    $('input[name=award_options]').val(JSON.stringify(this.awardOptions));
                    $("#donation-1").modal('hide');
                    this.errorsOptions = '';
                } else {
                    this.errorsOptions = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsOptions += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsOptions += '</ul>';
                }

            },


            processAwardOptions: function () {
                award = this.getAward(this.selectedAward);
                options = JSON.parse(award.options);

                errors = [];

                this.awardOptions = [];
                for (i = 0; i < options.length; i++) {
                    console.log(options[i]);
                    if (options[i].type == "choice") {
                        var sel = document.getElementById("award-option-" + i);
                        if (sel.selectedIndex == 0) {
                            errors.push(options[i].name + " is required");
                        } else {
                            this.awardOptions.push(options[i].name + ": " + sel.options[sel.selectedIndex].text);
                        }
                    }
                    if (options[i].type == "text") {
                        var field = document.getElementById("award-option-" + i);
                        if (field.value) {
                            if (field.value.length <= options[i].maxlength) {
                                this.awardOptions.push(options[i].name + ": " + field.value);
                            } else {
                                errors.push(options[i].name + " may not contain more than " + options[i].maxlength + " characters.");
                            }
                        } else {
                            errors.push(options[i].name + " is required");
                        }
                    }
                }

                if (errors.length == 0) {
                    $('input[name=award_options]').val(JSON.stringify(this.awardOptions));
                    $("#award-1").modal('hide');
                    this.errorsOptions = '';

                    // Reset PECSF Donation values in case user previous selected PECSF donation option
                    $('input[name=pecsf_region_id]').val(0);
                    $('input[name=pecsf_donation]').val(0);
                    $('input[name=pecsf_donation_type]').val(0);
                    $('input[name=pecsf_charity1_id]').val(0);
                    $('input[name=pecsf_amount1]').val(0);
                    $('input[name=pecsf_charity2_id]').val(0);
                    $('input[name=pecsf_amount2]').val(0);
                } else {
                    this.errorsOptions = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsOptions += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsOptions += '</ul>';
                }
            },

            milestoneSelected: function (milestone) {
                this.exposeAwardSelector(milestone);

                var sel = document.getElementById("milestone-id");
                this.milestone = sel.options[sel.selectedIndex].text;

                this.currentAwards = [];
                var donation = {
                    id: 0,
                    name: "PECSF Donation",
                    description: "Instead of choosing an award from the catalogue, you can opt to make a charitable donation via the Provincial Employees Community Services Fund. A framed certificate of service, signed by the Premier of British Columbia, will be presented to you noting your charitable contribution.",
                    image: "25_pecsf.jpg"
                };

                this.currentAwards.push(donation);

                for (var i = 0; i < awards.length; i++) {
                    if (awards[i].milestone_id == milestone) {
                        this.currentAwards.push(awards[i]);
                    }
                }

                this.currentAwardIndex = 0;
                this.updateAwardDisplay(this.currentAwardIndex);

                var record = this.getMilestone(milestone);
                this.milestonePersonalized = record.personalized;
                if (record.personalized) {
                    $('input[name=certificate_name]').val("");
                }
            },

            showPreviousAward: function () {
                this.currentAwardIndex--;
                if (this.currentAwardIndex < 0) {
                    this.currentAwardIndex = this.currentAwards.length - 1;
                }
                this.updateAwardDisplay(this.currentAwardIndex);
            },

            showNextAward: function () {
                this.currentAwardIndex++;
                if (this.currentAwardIndex >= this.currentAwards.length) {
                    this.currentAwardIndex = 0;
                }
                this.updateAwardDisplay(this.currentAwardIndex);
            },

            updateAwardDisplay: function (awardIndex) {
                this.currentAwardName = this.currentAwards[awardIndex].name;
                this.currentAwardImage = this.currentAwards[awardIndex].image;
                this.currentAwardDescription = nl2br(this.currentAwards[awardIndex].description);
                if (this.selectedAward == this.currentAwards[awardIndex].id) {
                    $('#lsa-award-card').css('background-color', 'lightblue');
                } else {
                    $('#lsa-award-card').css('background-color', 'transparent');
                }
            },


            selectCurrentAward: function () {
                this.CurrentAward = this.highlightedAward;

            },


            buttonMissedCeremony: function (missed) {
                if (missed == 1) {
                    this.selectAward = false;
                    this.showIdentifyingInfoInputs();
                } else {
                    this.selectAward = true;
                }
            },

            buttonRetirementClick: function (retiring) {
                $('input[name=retiring_this_year]').val(retiring);
                if (retiring == 1) {
                    this.exposeRetirementDatePicker();
                } else {
                    this.setRetirementStatusKnown();
                }
                $('html, body').animate({
                    scrollTop: $("#employeeAnchor").offset().top
                }, 1000);
            },

            exposeRetirementDatePicker: function () {
                this.isRetiringThisYear = true;
                this.retirementStatusKnown = true;
            },

            setRetirementStatusKnown: function () {
                this.isRetiringThisYear = false;
                this.retirementStatusKnown = true;
            },

            exposeAwardSelector: function (milestone) {
                this.milestoneKnown = true;
            },

            showIdentifyingInfoInputs: function () {
                this.awardConfirmed = true;
            },

            showOfficeAddressInput: function () {

                errors = this.checkIdentifyingInfo();
                if (errors.length == 0) {
                    $('html, body').animate({
                        scrollTop: $("#officeAnchor").offset().top
                    }, 1000);

                    this.identifyingInfoInput = true;
                    this.errorsEmployee = '';
                } else {

                    this.errorsEmployee = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsEmployee += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsEmployee += '</ul>';
                }
            },

            showHomeAddressInput: function () {

                errors = this.checkOfficeAddressInput();
                if (errors.length == 0) {
                    $('html, body').animate({
                        scrollTop: $("#homeAnchor").offset().top
                    }, 1000);
                    this.officeAddressInput = true;
                    this.errorsOffice = '';
                } else {
                    this.errorsOffice = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsOffice += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsOffice += '</ul>';
                }
            },

            showSupervisorInput: function () {
                errors = this.checkHomeAddressInput();
                if (errors.length == 0) {
                    $('html, body').animate({
                        scrollTop: $("#supervisorAnchor").offset().top
                    }, 1000);
                    this.homeAddressInput = true;
                    this.errorsHome = '';
                } else {
                    this.errorsHome = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsHome += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsHome += '</ul>';
                }
            },

            showConfirmation: function () {
                errors = this.checkSupervisorInput();
                if (errors.length == 0) {
                    $('html, body').animate({
                        scrollTop: $("#confirmationAnchor").offset().top
                    }, 1000);
                    this.supervisorInput = true;
                    this.errorsSupervisor = '';
                } else {
                    this.errorsSupervisor = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errorsSupervisor += '<li>' + errors[i] + '</li>';
                    }
                    this.errorsSupervisor += '</ul>';
                }
            },

            showDeclaration: function () {
                this.informationConfirmed = true;
                $('html, body').animate({
                    scrollTop: $("#declarationAnchor").offset().top
                }, 1000);
            },

            currencyFormat: function (num) {
                return '$' + parseFloat(num).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            },

            checkIdentifyingInfo: function () {

                var error = [];

                if (!this.employeeID) {
                    $('#employee-id').css("border-color", clrError);
                    error.push('Employee ID is required');
                } else {
                    $('#employee-id').css("border-color", clrDefault);
                }

                if (!this.firstName) {
                    $('#first-name').css("border-color", clrError);
                    error.push('Employee first name is required');
                } else {
                    $('#first-name').css("border-color", clrDefault);
                }

                if (!this.lastName) {
                    $('#last-name').css("border-color", clrError);
                    error.push('Employee last name is required');
                } else {
                    $('#last-name').css("border-color", clrDefault);
                }

                if (!this.ministry) {
                    $('#ministry-id').css("border-color", clrError);
                    error.push('Ministry is required');
                } else {
                    $('#ministry-id').css("border-color", clrDefault);
                }

                if (!this.ministryBranch) {
                    $('#branch').css("border-color", clrError);
                    error.push('Branch is required');
                } else {
                    $('#branch').css("border-color", clrDefault);
                }

                if (!this.govtEmail) {
                    $('#preferred-email').css("border-color", clrError);
                    error.push('Government Email is required.');
                } else {
                    if (!isEmail(this.govtEmail)) {
                        $('#preferred-email').css("border-color", clrError);
                        error.push('Government Email invalid format');
                    } else {
                        $('#preferred-email').css("border-color", clrDefault);
                    }
                }

                if (this.altEmail) {
                    if (!isEmail(this.altEmail)) {
                        $('#alternate-email').css("border-color", clrError);
                        error.push('Alternate Email invalid format');
                    } else {
                        $('#alternate-email').css("border-color", clrDefault);
                    }
                }

                return error;
            },

            checkOfficeAddressInput: function () {

                var error = [];

                if (!this.officeStreetAddress) {
                    $('#office-address').css("border-color", clrError);
                    error.push('Office Address is required');
                } else {
                    $('#office-address').css("border-color", clrDefault);
                }

                if (!this.officeCity) {
                    $('#office-city-id').css("border-color", clrError);
                    error.push('Office City is required');
                } else {
                    $('#office-city-id').css("border-color", clrDefault);
                }

                if (!this.officePostalCode) {
                    $('#office-postal-code').css("border-color", clrError);
                    error.push('Office Postal Code is required');
                } else {
                    if (!isPostalCode(this.officePostalCode)) {
                        $('#office-postal-code').css("border-color", clrError);
                        error.push('Office Postal Code invalid format (A1A 1A1)');
                    } else {
                        $('#office-postal-code').css("border-color", clrDefault);
                    }
                }

                if (!this.officePhone) {
                    $('#work-phone').css("border-color", clrError);
                    error.push('Office Phone number is required');
                } else {
                    if (!isPhone(this.officePhone)) {
                        $('#work-phone').css("border-color", clrError);
                        error.push('Office Phone number invalid format (###) ###-####');
                    } else {
                        $('#work-phone').css("border-color", clrDefault);
                    }
                }

                return error;
            },

            checkHomeAddressInput: function () {

                var error = [];

                if (!this.homeStreetAddress) {
                    $('#home-address').css("border-color", clrError);
                    error.push('Home Address is required');
                } else {
                    $('#home-address').css("border-color", clrDefault);
                }

                if (!this.homeCity) {
                    $('#home-city-id').css("border-color", clrError);
                    error.push('Home City is required');
                } else {
                    $('#home-city-id').css("border-color", clrDefault);
                }

                if (!this.homePostalCode) {
                    $('#home-postal-code').css("border-color", clrError);
                    error.push('Home Postal Code is required');
                } else {
                    if (!isPostalCode(this.homePostalCode)) {
                        $('#home-postal-code').css("border-color", clrError);
                        error.push('Home Postal Code invalid format (A1A 1A1)');
                    } else {
                        $('#home-postal-code').css("border-color", clrDefault);
                    }
                }

                if (!this.homePhone) {
                    $('#home-phone').css("border-color", clrError);
                    error.push('Home Phone number is required');
                } else {
                    if (!isPhone(this.homePhone)) {
                        $('#home-phone').css("border-color", clrError);
                        error.push('Home Phone number invalid format (###) ###-####');
                    } else {
                        $('#home-phone').css("border-color", clrDefault);
                    }
                }

                return error;
            },


            checkSupervisorInput: function () {

                var error = [];

                if (!this.supervisorFirstName) {
                    $('#supervisor-first-name').css("border-color", clrError);
                    error.push('Supervisor First Name is required');
                } else {
                    $('#supervisor-first-name').css("border-color", clrDefault);
                }

                if (!this.supervisorLastName) {
                    $('#supervisor-last-name').css("border-color", clrError);
                    error.push('Supervisor last name is required');
                } else {
                    $('#supervisor-last-name').css("border-color", clrDefault);
                }

                if (!this.supervisorStreetAddress) {
                    $('#supervisor-address').css("border-color", clrError);
                    error.push('Supervisor Address is required');
                } else {
                    $('#supervisor-address').css("border-color", clrDefault);
                }

                if (!this.supervisorCity) {
                    $('#supervisor-city-id').css("border-color", clrError);
                    error.push('Supervisor City is required');
                } else {
                    $('#supervisor-city-id').css("border-color", clrDefault);
                }

                if (!this.supervisorPostalCode) {
                    $('#supervisor-postal-code').css("border-color", clrError);
                    error.push('Supervisor Postal Code is required');
                } else {
                    if (!isPostalCode(this.supervisorPostalCode)) {
                        $('#supervisor-postal-code').css("border-color", clrError);
                        error.push('Supervisor Postal Code invalid format (A1A 1A1)');
                    } else {
                        $('#supervisor-postal-code').css("border-color", clrDefault);
                    }
                }

                if (!this.supervisorEmail) {
                    $('#supervisor-email').css("border-color", clrError);
                    error.push('Supervisor Email is required');
                } else {
                    if (!isEmail(this.supervisorEmail)) {
                        $('#supervisor-email').css("border-color", clrError);
                        error.push('Supervisor Email invalid format');
                    } else {
                        $('#supervisor-email').css("border-color", clrDefault);
                    }
                }

                return error;
            },

        }
    });



    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function isPhone(phone) {
        var regex = /\(([0-9]{3})\) ([0-9]{3})-([0-9]{4})/;
        return regex.test(phone);
    }

    function isPostalCode(code) {
        var regex = /^[ABCEGHJ-NPRSTVXY][0-9][ABCEGHJ-NPRSTV-Z] [0-9][ABCEGHJ-NPRSTV-Z][0-9]$/;
        return regex.test(code);
    }

    function nl2br(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    Vue.config.devtools = true;


</script>
<script>
    $(document).ready(function(){
        $('.phone-input').inputmask('(999) 999 - 9999');
        $('.postal-code-input').inputmask('A9A 9A9');
        $('.extension-input').inputmask('9[999]');
        $('.email-input').inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    casing: "lower"
                }
            }
        });
    })

</script>
