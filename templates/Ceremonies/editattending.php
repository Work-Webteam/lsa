<div class="container" id="app">
<h1 class="page-title">Edit Attendee</h1>

<?php

    echo $this->Form->create($ceremony, ['@submit' => 'processForm']);

    echo $this->Form->control('ministry_id', ['options' => $ministries, 'empty' => '- select ministry -', 'value' => $attending['ministry']]);

?>

    <label>Milestones</label>

<?php

    foreach ($milestones as $key => $milestone) {
        $selected =  in_array($milestone->id, $attending['milestone']);
        echo $this->Form->control('milestone-' . $milestone->id, ['type' => 'checkbox', 'label' => $milestone->name, 'value' => 1, 'checked' => $selected]);
    }



//    echo $this->Form->select('city_id', $cities, ['label' => 'City']);
    echo $this->Form->control('city_id', ['options' => $cities, 'empty' => '- all cities -', 'value' => $attending['city']['id'], 'onChange' => 'app.citySelected(this.value)']);
    echo $this->Form->control('city_type', ['options' => [0 => 'exclude', 1 => 'include'], 'value' => $attending['city']['type'], 'label' => '']);

    echo $this->Form->control('name_filter', ['type' => 'checkbox', 'onChange' => 'app.nameSelected()', 'checked' => !empty($attending['name']['start'])]);
?>


    <div id="name-filter" v-if="nameFilter">

<?php
    echo $this->Form->control('name_start', ['value' => isset($attending['name']['start']) ? $attending['name']['start'] : ""]);
    echo $this->Form->control('name_end', ['value' => isset($attending['name']['end']) ? $attending['name']['end'] : ""]);
?>

    </div>

                <div id="pop-up-errors">
                        <span v-html="msgErrors" class="lsa-errors-container">
                        </span>
                </div>

<?php
    echo $this->Form->button(__('Save Attending'), array('class' => 'btn btn-primary'));
    echo '&nbsp;';
    echo $this->Form->button('Cancel', array(
        'type' => 'button',
        'onclick' => 'location.href=\'/ceremonies/view/' . $ceremony->id .'\'',
        'class' => 'btn btn-secondary',
    ));

    echo $this->Form->end();

?>

</div>

<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-router/3.1.3/vue-router.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.0/smooth-scroll.min.js"></script>

<script type="text/javascript">

    var clrError = "#ff0000";
    var clrDefault = "#d1d1d1";
    var milestones = <?php echo json_encode($milestones); ?>;

    var app = new Vue({
        el: '#app',

        data: {
            ministry: '',
            milestone: '',
            city: <?php echo empty($attending['city']['id']) ? "0" : $attending['city']['id']; ?>,
            msgErrors: '',
            nameFilter: <?php echo empty($attending['name']['start']) ? 0 : 1; ?>,
        },

        mounted() {
            if (this.city == "") {
                $('#city-type').hide();
            }
        },


        methods: {

            processForm: function (e) {
                errors = [];

                if ($('#ministry-id').val().length == 0) {
                    console.log('no value?');
                    $('#ministry-id').css("border-color", clrError);
                    errors.push('Ministry is required');
                }
                else {
                    console.log('we got a value');
                    $('#ministry-id').css("border-color", clrDefault);
                }

                checked = false;
                for (var i = 0; i < milestones.length; i++) {
                    if ($('#milestone-' + milestones[i].id).prop("checked") ) {
                        checked = true;
                    }
                }
                if (!checked) {
                    errors.push('At least one milestone required');
                }


                if ($('#name-filter').prop("checked")) {
                    if ($('#name-start').val().length == 0) {
                        errors.push('Start letter required');
                    }
                    if ($('#name-end').val().length == 0) {
                        errors.push('End letter required');
                    }
                }


                if (errors.length > 0) {
                    this.msgErrors = '<ul>';
                    for (var i = 0; i < errors.length; i++) {
                        this.msgErrors += '<li>' + errors[i] + '</li>';
                    }
                    this.msgErrors += '</ul>';
                    e.preventDefault();
                } else {
                    this.msgErrors = '';
                }
            },


            citySelected: function (id) {
                if (id !== '') {
                    $('#city-type').show();
                } else {
                    $('#city-type').hide();
                }
            },

            nameSelected: function() {
                this.nameFilter = !this.nameFilter;
            },

        }
    });


</script>
