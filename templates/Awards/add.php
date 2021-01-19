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

<form method="post">
    <div class="form-row">
        <div class="col-6">
            <div class="image-area mt-4"><img id="imageResult" src="#" alt="" class="img-fluid rounded shadow-sm mx-auto d-block"></div>

        </div>
        <div class="col-6">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="upload" name="upload" onchange="readURL(this);">
                <label class="custom-file-label" for="upload">Upload image</label>
            </div>


        </div>
    </div>

    <div class="form-row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">Award Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Award Name">
        </div>
        <div class="form-group">
            <label for="milestone_id">Milestone:</label>
            <select class="form-control" id="milestone_id" name="milestone_id">
                <option selected disabled>Select Milestone</option>
                <?php foreach ($milestones as $mstone): ?>
                    <option value="<?= $mstone->id ?>"><?= $mstone->name ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label for="abbreviation">Abbreviation:</label>
            <input type="text" class="form-control" id="abbreviation" name="abbreviation" placeholder="Shortname">
            <small id="abbreviation-help" class="form-text text-muted">Provide a one-word description of the item</small>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
        </div>
        <p>Personalized:</p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="true" id="personalized">
            <label class="form-check-label" for="personalized">
                Personalization
            </label>
        </div>
    </div>
    </div>


    <div class="form-group">
        <button class="btn btn-cancel">Cancel</button>
        <button type="submit" class="btn btn-primary">Save award</button>
    </div>





</form>

