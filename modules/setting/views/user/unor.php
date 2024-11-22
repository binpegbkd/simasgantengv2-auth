<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttrIzinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Update User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attr-izin-index">

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pengguna')->textInput(['value'=> $model['nipBaru'].' '.$model['namapengguna'], 'disabled' => true]) ?>
        
    <?php echo $form->field($model, 'tablok')->widget(Select2::classname(), [
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
    
    <?= $form->field($model, 'namaopd')->textInput()->label('Nama OPD Tersimpan') ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>&nbsp;
        <?= Html::a('Batal', Url::previous(),['class' => 'btn btn-danger', 'title' => 'Batal']) ?>
    </div>
<?php ActiveForm::end(); ?>
    
</div>