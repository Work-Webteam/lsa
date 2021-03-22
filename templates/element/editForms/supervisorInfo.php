<div class="row"><h2 id="supervisorInfo">Supervisor Information</h2></div>

<div class="row">
    <div class="col-4">
        <?= $this->Form->control('supervisor_first_name', ['label' => 'Supervisor First Name', 'class' => 'form-control', 'v-model' => 'supervisorFirstName']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('supervisor_last_name', ['label' => 'Supervisor Last Name', 'class' => 'form-control', 'v-model' => 'supervisorLastName']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('supervisor_email', ['label' => 'Supervisor Email', 'class' => 'form-control', 'v-model' => 'supervisorEmail', '@change' => 'filterSupervisorEmail']); ?>
    </div>

    <div class="col-4">
        <?= $this->Form->control('supervisor_careof', ['label' => 'Floor / Room / Care Of', 'class' => 'form-control', 'v-model' => 'supervisorMailPrefix']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('supervisor_suite', ['label' => 'Suite', 'class' => 'form-control', 'v-model' => 'supervisorSuite']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('supervisor_address', ['label' => 'Address', 'class' => 'form-control', 'v-model' => 'supervisorStreetAddress']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('supervisor_city_id', ['label' => 'City', 'class' => 'form-control', 'options' => $cities, 'empty' => '- select city -', 'v-model' => 'supervisorCity']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('supervisor_postal_code', ['label' => 'Postal Code', 'class' => 'form-control', 'v-model' => 'supervisorPostalCode', '@change' => 'filterSupervisorPostalCode']); ?>
    </div>
    <div class="col-4">
    </div>
</div>
