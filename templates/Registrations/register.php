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
                                <?= $this->element('registrationForm/stepOne') ?>
                            </v-stepper-content>

                            <v-stepper-content class="grey lighten-3" step="2">
                                <?= $this->element('registrationForm/stepTwo') ?>
                            </v-stepper-content>


                            <v-stepper-content class="grey lighten-3" step="3">
                                <?= $this->element('registrationForm/stepThree') ?>

                            </v-stepper-content>

                            <v-stepper-content class="grey lighten-3" step="4">
                                <?= $this->element('registrationForm/stepFour') ?>

                            </v-stepper-content>

                            <v-stepper-content class="grey lighten-3" step="5">
                                <?= $this->element('registrationForm/stepFive') ?>
                            </v-stepper-content>


                        </v-stepper-items>

                    </v-stepper>
                </v-container>
            </v-main>
        </v-app>
    </template>
</div>
<?= $this->Form->end(); ?>

<!-- Data-types TODO: Check for usage and eliminate superfluous calls -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>


<!-- Registration Form-specific JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js" integrity="sha512-VpQwrlvKqJHKtIvpL8Zv6819FkTJyE1DoVNH0L2RLn8hUPjRjkS/bCYurZs0DX9Ybwu9oHRHdBZR9fESaq8Z8A==" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

<script src="/js/registration/registration-info.js"></script>

<script>

    Vue.config.devtools = true;



</script>

