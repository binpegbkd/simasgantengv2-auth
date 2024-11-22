<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">
    <div class="row">
    <?php $form = ActiveForm::begin(); ?>
    
        <div class="col-sm-3">&nbsp;</div>

        <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>
                <?php //<?= $form->field($model, 'username')->textInput(['class' => 'form-control class-content-title_series', 'disabled' => true]) ?>
                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>               
                    
                <?php /* echo $form->field($model, 'role')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\Tipes::find()->all(),'tipe','namatipe'),
                    'language' => 'id',
                    'options' => [
                      'placeholder' => '- Pilih -',
                      'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); */?>           
          
                <?= $form->field($model, 'pengguna')->textInput(['value'=> $model['userPegawai']['NamaPns'], 'class' => 'form-control class-content-title_series', 'disabled' => true]) ?>
	    <div class="form-group">
	        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>&nbsp;
          <?= Html::a('Batal', Url::previous(),['class' => 'btn btn-danger', 'title' => 'Batal']) ?>
	    </div>
	</div>
    <?php ActiveForm::end(); ?>
	</div>
</div>