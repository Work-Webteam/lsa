<h1 class="page-title">Edit Award</h1>
<?php
echo $this->Form->create($award, ['type' => 'file']);

echo $this->Form->control('name');
echo $this->Form->control('abbreviation');
echo $this->Form->control('milestone_id', ['options' => $milestones]);
echo $this->Form->control('description', ['type' => 'textarea', 'rows' => '6', 'cols' => '50']);
echo $this->Form->control('personalized', ['type' => 'checkbox']);
echo $this->Html->image('awards/'.$award->image);
echo $this->Form->control('upload', ['type' => 'file']);

echo $this->Form->button(__('Save Award'), array('class' => 'btn btn-primary'));
echo '&nbsp;';
echo $this->Form->button('Cancel', array(
    'type' => 'button',
    'onclick' => 'location.href=\'/awards\'',
    'class' => 'btn btn-secondary'
));

echo $this->Form->end();
?>

<h1 class="page-title">Edit Award</h1>

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
    /*  ==========================================
    SHOW UPLOADED IMAGE
* ========================================== */
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageResult')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(function () {
        $('#upload').on('change', function () {
            readURL(input);
        });
    });

    /*  ==========================================
        SHOW UPLOADED IMAGE NAME
    * ========================================== */
    var input = document.getElementById( 'upload' );
    var infoArea = document.getElementById( 'upload-label' );

    input.addEventListener( 'change', showFileName );
    function showFileName( event ) {
        var input = event.srcElement;
        var fileName = input.files[0].name;
        infoArea.textContent = 'File name: ' + fileName;
    }

</script>

<?= $this->Form->create($award) ?>
<div class="form-row">
    <div class="col-6">
        <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>

    </div>
    <div class="col-6">
        <div class="custom-file">
            <?= $this->Form->control('upload', ['type' => 'file', 'class' => 'form-control custom-file-input', 'onchange="readURL(this);"']) ?>
            <input type="file" class="custom-file-input" id="upload" name="upload" onchange="readURL(this);">
            <label class="custom-file-label" for="upload">Upload image</label>
        </div>


    </div>
</div>

<div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">Award Name:</label>
            <?= $this->Form->control('name', ['class' => 'form-control']); ?>

        </div>
        <div class="form-group">
            <label for="milestone_id">Milestone:</label>
            <?= $this->Form->control('milestone_id', ['label' => 'Milestone', 'class' => 'form-control', 'options' => $milestones]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('abbreviation', ['label' => 'Abbreviation', 'class' => 'form-control', 'placeholder' => 'Shortname']); ?>
            <small id="abbreviation-help" class="form-text text-muted">Provide a one-word description of the item</small>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="description">Description:</label>
            <?= $this->Form->control('description', ['label' => 'Description', 'class' => 'form-control', 'type' => 'textarea']); ?>
        </div>
        <div class="form-check">
            <?= $this->Form->control('personalized', ['label' => 'Personalized', 'class' => 'form-control']);?>
        </div>
    </div>
</div>


<?= $this->Form->button('Cancel', [
    'type' => 'button',
    'onclick' => 'location.href=\'/awards/view/' . $award->id . '\'',
    'class' => 'btn btn-cancel'
]);
?>
<?= $this->Form->button(__('Save Award'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end(); ?>
