<div class="row"><h2 id="personalContact">Personal Contact Information</h2></div>

<div class="row">
    <div class="col-4">
        <?= $this->Form->control('alternate_email', ['label' => 'Home Email', 'class' => 'form-control', 'v-model' => 'altEmail', '@change' => 'filterAltEmail']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('home_phone', ['label' => 'Phone', 'class' => 'form-control', 'v-model' => 'homePhone', '@change' => 'filterHomePhoneNumber']); ?>
    </div>
    <div class="col-4">
    </div>
    <div class="col-4">
        <?= $this->Form->control('home_suite', ['label' => 'Suite', 'class' => 'form-control', 'v-model' => 'homeSuite']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('home_address', ['label' => 'Address', 'class' => 'form-control', 'v-model' => 'homeStreetAddress']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('home_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -', 'class' => 'form-control', 'v-model' => 'homeCity']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('home_postal_code', ['label' => 'Postal Code', 'class' => 'form-control', 'v-model' => 'homePostalCode', '@change' => 'filterHomePostalCode']); ?>
    </div>
</div>
