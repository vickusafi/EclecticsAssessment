<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(['id' => 'loan-form', 'enableAjaxValidation' => false]); ?>

<div class="form-group">

    <?= $form->field($model, 'loan_type_id')->dropDownList($loan_types, ['prompt' => 'Select type of loan'])->label('Loan Type') ?>

</div>
<div class="form-group">
    <?= $form->field(
        $model,
        'amount'

    )->textInput([
        'placeholder' => 'loan amount'
    ])->label('Loan Amount')
    ?>
</div>


<div class="form-group">
    <?= Html::a('Cancel', ['list'], ['class' => 'btn btn-default float-left', 'data-dismiss' => 'modal']) ?>
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary ml-4 float-right', 'name' => 'loan-button']) ?>
</div>
<?php ActiveForm::end(); ?>