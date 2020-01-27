<div class="container" id="app">
<h1>Form Test</h1>

<?php



echo $this->Form->create($registration);
?>

    <transition name="fade">
        <div class="form-group">
    <?php


    echo $this->Form->control('milestone_id', ['label' => 'Milestone', 'options' => $milestones, 'empty' => '- select milestone -', 'onChange' => 'milestoneSelected(this.value)']);
?>
        </div>
    </transition>

    <transition name="fade">
        <div class="form-group" v-if="milestoneKnown">

<?php

// echo $this->Form->control('award_id', ['type' => 'select', 'options' => $awards, 'empty' => '- select award -', 'onChange' => 'awardSelected(this.value)']);
echo $this->Form->control('work_phone', ['v-model' => 'officePhone']);

//             <a class="btn btn-primary" data-target="#award-1" data-toggle="modal" href="#">Select This One</a>
?>
            <a class="btn btn-primary" href="#identifyingInfo" v-on:click="showConfirmation">Selected Award</a>

<br><br>

            <a class="btn btn-primary" href="#" onclick="showOptions()">Select This One</a>


        </div>
    </transition>




<transition name="fade">
   <div class="confirmationDisplay" v-if="supervisorInput">

       <h3 class="display-4">Please Confirm Your Information</h3>

       <h4>{{firstName}}
           {{lastName}}</h4>

       <p>Milestone: {{ milestone }}</p>
       <p>Award: {{ awardName }}</p>

       <div id="register">
       <?php
       echo $this->Form->button(__('Register'));
       echo $this->Form->button('Cancel', array(
           'type' => 'button',
           'onclick' => 'location.href=\'/registrations\''
       ));
       ?>
       </div>
   </div>
</transition>
    <div>
<?php

echo $this->Form->end();
?>
    </div>

        <div aria-hidden="true" aria-labelledby="Award The First" class="modal fade" id="award-1" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Award The First</h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Modal Form Elements Will Go Here to allow people to pick options relevant to the award.</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                        <button class="btn btn-primary" type="button">Select</button>
                    </div>
                </div>
            </div>
        </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>


<script type="text/javascript">

    var milestones=<?php echo json_encode($milestones); ?>;


    $(function () {
        $('#datetimepicker1').datetimepicker({format: 'L'});
    });

    function showOptions() {
        console.log("showOptions");
        $("#award-1").modal('show');
    }

    function buttonRetirementClick(retiring) {
        $('input[name=retiring_this_year]').val(retiring);
        if (retiring == 1) {
            app.exposeRetirementDatePicker();
        }
        else {
            app.setRetirementStatusKnown();
        }
    }

    function buttonMissedCeremony(missed) {
        if (missed == 1) {
            app.selectAward = false;
            app.showIdentifyingInfoInputs();
        }
        else {
            app.selectAward = true;
        }
    }

    function milestoneSelected(milestone) {
        app.exposeAwardSelector(milestone);

        var sel = document.getElementById("milestone-id");
        app.milestone = sel.options[sel.selectedIndex].text;
    }

    function awardSelected(city) {
        var sel = document.getElementById("award-id");
        app.awardName = sel.options[sel.selectedIndex].text;
        app.awardDescription = 'Description of ' + app.awardName;
    }


    function officeCitySelected(city) {
        var sel = document.getElementById("office-city-id");
        app.officeCity = sel.options[sel.selectedIndex].text;
    }

    function homeCitySelected(city) {
        var sel = document.getElementById("home-city-id");
        app.homeCity = sel.options[sel.selectedIndex].text;
    }

    function supervisorCitySelected(city) {
        var sel = document.getElementById("supervisor-city-id");
        app.supervisorCity = sel.options[sel.selectedIndex].text;
    }

    function ministrySelected(city) {
        var sel = document.getElementById("ministry-id");
        app.ministry = sel.options[sel.selectedIndex].text;
    }


    Vue.config.devtools = true;


    var app = new Vue({
        el: "#app",
        data: {
            isRetiringThisYear: false,
            retirementStatusKnown: false,
            retirementDate: '',
            yearsOfService: 0,
            milestoneKnown: false,
            milestone: '',

            employeeID: '',
            firstName: '',
            lastName: '',
            altEmail: '',

            ministry: '',
            branch: '',
            officeMailPrefix: '',
            officeSuite: '',
            officeStreetAddress: '',
            officeCity: '',
            officePostalCode: '',
            officePhone: '',
            homeSuite: '',
            homeStreetAddress: '',
            homeCity: '',
            homePostalCode: '',
            homePhone: '',
            supervisorFirstName: '',
            supervisorLastName: '',
            supervisorMailPrefix: '',
            supervisorSuite: '',
            supervisorStreetAddress: '',
            supervisorCity: '',
            supervisorPostalCode: '',
            supervisorEmail: '',

            awardName: '',
            awardDescription: '',
            awardOptions: ['option 1', 'option 2'],
            awardImage: 'Watches-group-thumb.png',

            selectAward: false,
            awardSelected: false,
            identifyingInfoInput: false,
            officeAddressInput: false,
            homeAddressInput: false,
            supervisorInput: false,
            informationConfirmed: false,

        },
        methods: {
            exposeRetirementDatePicker: function () {
                this.isRetiringThisYear = true;
                this.retirementStatusKnown = true;
            },

            setRetirementStatusKnown: function () {
                this.isRetiringThisYear = false;
                this.retirementStatusKnown = true;
            },

            exposeAwardSelector: function(milestone) {
                this.milestoneKnown = true;
            },

            showIdentifyingInfoInputs: function () {
                this.awardSelected = true;
            },

            showOfficeAddressInput: function () {
                this.identifyingInfoInput = true;
            },

            showHomeAddressInput: function () {
                this.officeAddressInput = true;
            },

            showSupervisorInput: function () {
                this.homeAddressInput = true;
            },

            showConfirmation: function () {
                this.supervisorInput = true;
            },

            showDeclaration: function () {
                this.informationConfirmed = true;
            }


        }
    })
    var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 1500
    });


</script>
