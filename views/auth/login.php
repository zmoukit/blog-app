<?php

use Core\Form\Form;

$model = $params['model'];
?>

<h3>Sign in</h3>

<?php $form = Form::begin("", "POST") ?>


<div class="row mb-3">
    <div class="col-4">
        <?php echo $form->field($model, 'email'); ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-4">
        <?php echo $form->field($model, 'password')->passwordField(); ?>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
</div>

<?php Form::end(); ?>