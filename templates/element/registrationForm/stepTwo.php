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
    <div class="col-4"></div>
    <div class="col-4">
        <?= $this->element('formComponents/watchOptions'); ?>
    </div>
    <div class="col-4"></div>
</div>

<!-- 35 YR BRACELET CONTROLS -->
<div class="row" v-if="displayBracelet">

    <div class="col-4"></div>
    <div class="col-4">
        <?= $this->element('formComponents/braceletOptions'); ?>
    </div>
    <div class="col-4"></div>
</div>

    <!-- PECSF DONATION CONTROLS -->
    <div class="row" v-if="displayPecsf">
        <div class="col-3"></div>
        <div class="col-6"><?= $this->element('formComponents/pecsfDonation'); ?></div>
        <div class="col-3"></div>
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
