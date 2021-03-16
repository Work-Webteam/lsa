<div class="row"> <h2 id="employeeInfo">Employee Information</h2> </div>

<div class="row">
    <div class="col-2">
        <?= $this->Form->control('employee_id', ['type'=> 'text', 'class' => 'form-control', 'label' => 'Employee ID', 'value' => $registration->employee_id , 'v-model' => 'employeeID']); ?>
    </div>
    <div class="col-2">
        <?= $this->Form->control('member_bcgeu', ['class' => 'form-control', 'label' => 'Member of BCGEU', 'v-model' => 'isBcgeuMember']); ?>
    </div>
    <div class="col-2">
       <!-- //$this->Form->control('',['class' => '', 'label' => '', 'v-model'=> '']); -->
       <?= $this->Form->control('retiring_this_year',['class' => 'form-control', 'label' => 'Retiring This Year', 'v-model'=> 'isRetiringThisYear']); ?>
    </div>
    <div v-if="isRetiringThisYear" class="col-2">
        <?= $this->Form->control('retirement_date',['class' => 'form-control', 'label' => 'Retirement Date', 'v-model'=> 'retirementDate']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('first_name', ['class' => 'form-control', 'label' => 'First Name', 'v-model' => 'firstName']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('last_name', ['class' => 'form-control', 'label' => 'Last Name', 'v-model' => 'lastName']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('ministry_id', ['type' => 'select', 'options' => $ministries, 'class' => 'form-control', 'label' => 'Member Organization', 'empty' => '- select ministry -', 'v-model' => 'ministry']); ?>
    </div>
    <div class="col-4">
        <?= $this->Form->control('branch', ['label' => 'Branch', 'class' => 'form-control']); ?>
    </div>
    <div class="col-4">

    </div>
</div>
