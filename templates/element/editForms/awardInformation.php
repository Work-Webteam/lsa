
<div class="row"> <h2 >Award Information</h2></div>

<div class="row">
    <div class="col-4">
        <?= $this->Form->control('milestone_id', ['options' => $milestones, 'class'=> 'form-control','v-model' => 'selectedMilestone']); ?>
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

    </div>
