<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-12">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_menu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($icon, 'icon', 'icon'),
            'language' => 'id',
            'options' => ['placeholder' => '- Pilih -'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
    <?= $form->field($model, 'tipe')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($tipes, 'id', 'namatipe'),
            'language' => 'id',
            'options' => ['placeholder' => '- Pilih -'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>&nbsp;
        <?= Html::button('Batal', ['class' => 'btn btn-danger','data-dismiss' => 'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
