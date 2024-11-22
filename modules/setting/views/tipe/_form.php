<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id', ['showLabels' => false])->hiddenInput() ?>
    <?= $form->field($model, 'namatipe')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
