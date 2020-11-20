<div class="container" id="app">
<h1>Add User Role</h1>
<?php
echo $this->Form->create($userrole, ['@submit' => 'checkForm']);
echo $this->Form->control('idir', ['type' => 'text', 'label' => 'IDIR', 'v-model' => 'idir', 'style' => 'text-transform: lowercase;']);
echo $this->Form->control('role_id', ['empty' => '- select role -', 'onChange' => 'app.showMinistry(this.value)']);
?>
    <div v-if="selectMinistry">
        <?= $this->Form->control('ministry_id', ['empty' => '- select ministry -']); ?>
    </div>
    <div>
     <span v-html="errors" class="lsa-errors-container">
     </span>
    </div>
    <?php

echo $this->Form->button(__('Save User Role'
)
    , array(
        'class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/userroles\'',
    'class' => 'btn btn-secondary',
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


    var app = new Vue({
        el: '#app',
        data: {
            selectMinistry: false,
            idir: '',
            roleID: 0,
            ministryID: 0,
            errors: '',
        },

        mounted() {
            sel = document.getElementById("role-id");
            this.roleID = sel.selectedIndex;
            this.showMinistry(this.roleID);
        },


        methods: {
            showMinistry: function (role_id) {
                this.roleID = role_id
                if (role_id == 5) {
                    this.selectMinistry = true;
                }
                else {
                    this.selectMinistry = false;
                }
            },

            checkForm: function (e) {
                var sel = document.getElementById("ministry-id");
                var selRole = document.getElementById("role-id");

                var errors = [];

                if (!this.idir) {
                    errors.push('IDIR is required');
                }
                if (selRole.selectedIndex == 0) {
                    errors.push ('Role is required');
                }
                if (this.roleID == 5 && sel.selectedIndex == 0) {
                    errors.push ('Ministry is required');
                }
                if (errors.length > 0) {
                    this.errors = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.errors += '<li>' + errors[i] + '</li>';
                    }
                    this.errors += '</ul>';
                    e.preventDefault();
                }
            }
        },
    });

</script>
