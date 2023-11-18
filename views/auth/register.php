<?php

use Core\Form\Form;

$model = $params["model"];
?>

<h3>Register</h3>
<?php $form =  Form::begin(" ", 'POST') ?>

<div class="row mb-3">
    <div class="col-3">
        <?php echo $form->field($model, 'first_name') ?>
    </div>

    <div class="col-3">
        <?php echo $form->field($model, 'last_name') ?>
    </div>
</div>


<div class="row mb-3">
    <div class="col-6">

        <?php echo $form->field($model, 'mobile') ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-6">
        <?php echo $form->field($model, 'email') ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-3">
        <?php echo $form->field($model, 'password')->passwordField() ?>
    </div>

    <div class="col-3">
        <?php echo $form->field($model, 'password_confirmation')->passwordField() ?>
    </div>

</div>


<div class="row">
    <div class="col-6">
        <button type="submit" class="btn btn-primary">Register</button>
        <div class="float-lg-end text-center">
            <a href="/login">Already have an account ?</a>
        </div>
    </div>
</div>

<?php echo Form::end() ?>