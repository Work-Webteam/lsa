

<div class="col-4">
        <?= $this->Form->create();?>
    <div class="form-group">
        <?php if (!empty($loginFail)) : ?>
                <div class="">
                    Your login information was incorrect.
                </div>
        <?php endif; ?>

        <?= $this->Form->control('username', ['label' => 'Username', 'class' => 'form-control']); ?>
    </div>


    <div class="form-group">
        <?= $this->Form->password('password', ['label' => 'Password', 'class'=> 'form-control']); ?>
    </div>
        <?= $this->Form->button('Login', ['class' => 'btn btn-primary']); ?>
        <?= $this->Form->end(); ?>
</div>




