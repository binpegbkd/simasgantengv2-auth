<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'fieldConfig' => ['options' => ['class' => 'form-group mb-3 mr-1 me-1']] 
    ]);?> 
        
    <?= $form->field($model, 'nipBaru')->textInput(['id' => 'tnip']) ?> 
    <?= $form->field($model, 'namapengguna')->textInput(['id' => 'tnama']) ?>  
    <?= $form->field($model, 'username')->textInput(['id' => 'tuser']) ?>  

    <?= $form->field($model, 'role')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($roles, 'id', 'namatipe'),
        'language' => 'id',
        'options' => [
            'placeholder' => '- Pilih -',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?> 

    <?= $form->field($model, 'tablok')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($opd, 'KOLOK', 'OPD'),
        'language' => 'id',
        'options' => [
            'placeholder' => '- Pilih -',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);?> 

    <?= $form->field($model, 'namaopd')->textInput(['id' => 'topd'])?>   
    
    <?= $form->field($model, 'status')->widget(Select2::classname(), [
        'data' => [10 => 'Aktif', 9 => 'Non aktif'],
    ]);?>   
    
    <div class="form-group mb-3 me-1">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary mr-1', 'id' => 'sr-button']) ?>
        <?= Html::a('Batal', Url::previous(), ['class' => 'btn btn-danger mr-1']) ?>        
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
$('#sr-button').click(function () {
    var c1 = $('#tnip').val();
    var c2 = $('#tnama').val();
    var c3 = $('#topd').val();
    var c4 = $('#user').val();
    if (c1 == '' && c2 == '' && c3 == '' && c4 == '') {
        Swal.fire({
            title : 'Error',
            text : 'Pencarian tidak boleh kosong !',
            icon : 'error',
            showConfirmButton : true,
            timer : 2000
        });
        return false;
    }
    return true;
});
JS;
$this->registerJs($script);
?>