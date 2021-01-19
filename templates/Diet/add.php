
<h1 class="page-title">Add Diet</h1>


<?= $this->Form->create($diet); ?>

<div class="form-group">
    <label for="name">Diet name:</label>
    <input type="text" class="form-control" id="name" name="name">
</div>

<button class="btn btn-cancel">Cancel</button>
<button type="submit" class="btn btn-primary">Save Diet</button>


<?= $this->Form->end(); ?>
