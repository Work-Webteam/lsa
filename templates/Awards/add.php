<h1 class="page-title">Add Award</h1>

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

<?= $this->Form->create($award, ['type' => 'file']) ?>
    <div class="form-row">
        <div class="col-6">
            <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>

        </div>
        <div class="col-6">
            <div class="custom-file">
                <?= $this->Form->control('upload', ['type' => 'file', 'class' => 'form-control custom-file-input', 'onchange="readURL(this);"']) ?>
                <label class="custom-file-label" for="upload">Upload image</label>
            </div>


        </div>
    </div>

    <div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <?= $this->Form->control('name', ['label' => 'Award Name', 'class' => 'form-control']); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->control('milestone_id', ['label' => 'Milestone', 'class' => 'form-control', 'options' => $milestones]); ?>
            </select>
        </div>
        <div class="form-group">
            <?= $this->Form->control('abbreviation', ['label' => 'Abbreviation', 'class' => 'form-control', 'placeholder' => 'Shortname']); ?>
            <small id="abbreviation-help" class="form-text text-muted">Provide a one-word description of the item</small>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
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
<?= $this->Form->button(__('Save Awrd'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end(); ?>
