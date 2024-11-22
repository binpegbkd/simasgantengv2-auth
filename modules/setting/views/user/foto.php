<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Upload Foto';

?>

<div class="row">
    <div class="col-lg-12">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'id')->hiddenInput(['value' => Yii::$app->user->identity['id']])->label(false) ?>

    <?= $form->field($model, 'foto')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showRemove'=> false,
            'showUpload' => false,
            'showCancel' => false,
            'overwriteInitial' => false,
            //'previewFileType' => 'image',
            'uploadAsync'=> true,
            'maxFileSize' => 200,
            'allowedFileExtensions' => ['jpg','png','jpeg','gif','bmp'], 
        ]
    ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>