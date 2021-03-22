 <div class="row"> <h2 id="workContact">Work Contact Information</h2></div>

        <div class="row">
            <div class="col-4">
                <?= $this->Form->control('preferred_email', ['label' => 'Government Email', 'class' => 'form-control', 'v-model' => 'govtEmail', '@change' => 'filterGovtEmail']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('work_phone', ['label' => 'Phone', 'class' => 'form-control', 'v-model' => 'officePhone', '@change' => 'filterOfficePhoneNumber']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('work_extension', ['label' => 'Phone Extension', 'class' => 'form-control', 'v-model' => 'officeExtension' ]); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('office_careof', ['label' => 'Floor/ Room / Care Of', 'class' => 'form-control', 'v-model' => 'officeMailPrefix']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('office_suite', ['label' => 'Suite', 'class' => 'form-control', 'v-model' => 'officeSuite']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('office_address', ['label' => 'Address', 'class' => 'form-control', 'v-model' => 'officeStreetAddress']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('office_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -', 'class' => 'form-control', 'v-model' => 'officeCity']); ?>
            </div>
            <div class="col-4">
                <?= $this->Form->control('office_postal_code', ['label' => 'Postal Code', 'class' => 'form-control', 'v-model' => 'officePostalCode', '@change' => 'filterOfficePostalCode']); ?>
            </div>
            <div class="col-4">
            </div>
        </div>
