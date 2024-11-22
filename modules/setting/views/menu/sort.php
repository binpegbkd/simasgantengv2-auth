<?php

use yii\helpers\Html;
use kartik\sortinput\SortableInput;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttrIzinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mengurutkan Menu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attr-izin-index">

<?php
//echo '<pre>'.Json::encode($urutan, JSON_PRETTY_PRINT).'</pre>';

$form = ActiveForm::begin(); 
    
echo '<div class="row">';
echo '<div class="col-lg-12">';

echo SortableInput::widget([
    'name'=> 'sort',
    //'value'=>'3,4,2,1,5',
    'items' => $urutan,
    'hideInput' => true,
    'options' => ['class'=>'form-control', 'readonly'=>true]
]);
echo Html::submitButton('Simpan', ['class' => 'btn btn-success']);
echo '</div>';
echo '</div>';
ActiveForm::end(); 
//echo Html::textInput('no', '', ['class' => 'form-control']);
?>
    
</div>