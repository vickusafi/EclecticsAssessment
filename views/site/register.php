<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',

            ]); ?>

            <?= $form->field($model, 'full_name')->textInput(['autofocus' => true])->label('Full Name') ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Email') ?>

            <?= $form->field($model, 'id_no')->textInput(['autofocus' => true])->label('ID No.') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>


            <div class="form-group">
                <div>
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
    </div>
</div>