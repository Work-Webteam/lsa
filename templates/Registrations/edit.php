<div class="container" id="app">
<h1>Edit Registration</h1>
<?php
    echo $this->Form->create($registration, ['horizontal' => true]);
?>

        <tabs>
            <tab name="Recipient" :selected="true">
                <h3>Recipient</h3>
                <?php
                    echo $this->Form->control('milestone_id', ['options' => $milestones]);
                    echo $this->Form->control('employee_id', ['type' => 'text', 'label' => 'Employee ID']);
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
//                    echo $this->Form->control('ministry_id', ['label' => 'Ministry']);
                    echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => '- select ministry -']);
                    echo $this->Form->control('department', ['label' => 'Branch']);
                    echo $this->Form->control('preferred_email', ['label' => 'Government Email']);
                ?>
            </tab>
            <tab name="Office">
                <h3>Office</h3>
                <?php
                    echo $this->Form->control('office_careof', ['label' => 'Floor/ Room / Care Of']);
                    echo $this->Form->control('office_address', ['label' => 'Address']);
                    echo $this->Form->control('office_suite', ['label' => 'Suite']);
                    echo $this->Form->control('office_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                    echo $this->Form->control('office_province', ['label' => 'Province']);
                    echo $this->Form->control('office_postal_code', ['label' => 'Postal Code']);
                    echo $this->Form->control('work_phone', ['label' => 'Phone']);
                    echo $this->Form->control('work_extension', ['label' => 'Phone Extension']);
                ?>
            </tab>
            <tab name="Home">
                <h3>Office</h3>
                <?php
                    echo $this->Form->control('home_address', ['label' => 'Address']);
                    echo $this->Form->control('home_suite', ['label' => 'Suite']);
                    echo $this->Form->control('home_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                    echo $this->Form->control('home_province', ['label' => 'Province']);
                    echo $this->Form->control('home_postal_code', ['label' => 'Postal Code']);
                    echo $this->Form->control('home_phone', ['label' => 'Phone']);
                ?>
            </tab>
            <tab name="Award">
                <h3>Award</h3>
                <?php
                    echo $this->Form->control('award_year', ['label' => 'Award Year']);
                    echo $this->Form->control('award_id', ['options' => $awards]);
                    echo $this->Form->control('award_received', ['type' => 'checkbox']);
                    echo $this->Form->control('engraving_sent', ['type' => 'checkbox']);
                    echo $this->Form->control('certificate_name');
                    echo $this->Form->control('certificate_ordered');
                    echo $this->Form->control('award_instructions', ['label' => 'Award Instructions', 'type' => 'textarea']);

                    if ($registration->pecsf_donation) {
                        echo $this->Form->control('pecsf_donation');
                        echo $this->Form->control('pecsf_region_id', ['options' => $regions]);
                        echo $this->Form->control('pecsf_charity1_id', ['options' => $charities]);
                        echo $this->Form->control('pecsf_amount1');
                        echo $this->Form->control('pecsf_second_charity');
                        echo $this->Form->control('pecsf_charity2_id', ['options' => $charities]);
                        echo $this->Form->control('pecsf_amount2');
                        echo $this->Form->control('pecsf_cheque_date');
                    }
                ?>
            </tab>
            <tab name="Ceremony">
                <h3>Ceremony</h3>
                    <?php
                    echo $this->Form->control('ceremony_id', ['label' => 'Ceremony Night']);
                    echo $this->Form->control('ceremony_date');
                    echo $this->Form->control('attending');
                    echo $this->Form->control('guest');
                    echo $this->Form->control('recipient_speaker');
                    echo $this->Form->control('reserved_seating');
                    echo $this->Form->control('executive_recipient');
                    echo $this->Form->control('presentation_number', ['label' => 'Award Presentation #']);
                    echo $this->Form->control('accessibility_requirements_recipient');
                    echo $this->Form->control('accessibility_requirements_guest');
                    echo $this->Form->control('accessibility_recipient_notes');
                    echo $this->Form->control('accessibility_guest_notes');
                    echo $this->Form->control('accessibility_admin_notes');
                    echo $this->Form->control('recipient_diet_id');
                    echo $this->Form->control('recipient_diet_other');
                    echo $this->Form->control('guest_diet_id');
                    echo $this->Form->control('guest_diet_other');
                    ?>
            </tab>
            <tab name="Supervisor">
                <h3>Supervisor</h3>
                <?php
                    echo $this->Form->control('supervisor_first_name', ['label' => 'First Name']);
                    echo $this->Form->control('supervisor_last_name', ['label' => 'Last Name']);
                    echo $this->Form->control('supervisor_careof', ['label' => 'Floor / Room / Care Of']);
                    echo $this->Form->control('supervisor_address', ['label' => 'Address']);
                    echo $this->Form->control('supervisor_suite', ['label' => 'Suite']);
                    echo $this->Form->control('supervisor_city_id', ['label' => 'City', 'options' => $cities, 'empty' => '- select city -']);
                    echo $this->Form->control('supervisor_province', ['label' => 'Province']);
                    echo $this->Form->control('supervisor_postal_code', ['label' => 'Postal Code']);
                    echo $this->Form->control('supervisor_email', ['label' => 'Email']);
                ?>
            </tab>
            <tab name="Admin">
                <h3>Admin</h3>
                <?php
                    echo $this->Form->control('survey_participation');
                    echo $this->Form->control('created');
                    echo $this->Form->control('invite_sent');
                    echo $this->Form->control('id');
                    echo $this->Form->control('photo_order');
                    echo $this->Form->control('photo_frame_range');
                    echo $this->Form->control('photo_sent');
                    echo $this->Form->control('admin_notes');
                ?>
            </tab>
        </tabs>

<?php
echo $this->Form->button(__('Save Registration'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/registrations\''
));
echo $this->Form->end();
?>
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

    var reg=<?php echo json_encode($registration); ?>;
    console.log(reg);

    Vue.component('tabs', {
        template: `
        <div>
            <div class="tabs">
              <ul>
                <li v-for="tab in tabs" :class="{ 'is-active': tab.isActive }">
                    <a :href="tab.href" @click="selectTab(tab)">{{ tab.name }}</a>
                </li>
              </ul>
            </div>

            <div class="tabs-details">
                <slot></slot>
            </div>
        </div>
    `,

        data() {
            return {tabs: [] };
        },

        created() {

            this.tabs = this.$children;

        },
        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == selectedTab.name);
                });
            }
        }
    });

    Vue.component('tab', {

        template: `

        <div v-show="isActive"><slot></slot></div>

    `,

        props: {
            name: { required: true },
            selected: { default: false}
        },

        data() {

            return {
                isActive: false
            };

        },

        computed: {

            href() {
                return '#' + this.name.toLowerCase().replace(/ /g, '-');
            }
        },

        mounted() {

            this.isActive = this.selected;

        }
    });

   var app = new Vue({
        el: '#app'
    });
</script>
