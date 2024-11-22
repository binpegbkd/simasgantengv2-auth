<?php

use yii\helpers\Html;
use kartik\sortinput\SortableInput;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AttrIzinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role User : '.$model['namapengguna'];
$this->params['breadcrumbs'][] = ['label' => 'Cari', 'url' => ['cari']];
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => Url::previous()];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attr-izin-index">

<?php 
$alurs = \app\models\Tipes::find()->orderBy(['id' => SORT_ASC])->all();
$alurs2 = explode(',', $model['role']);

$x = ArrayHelper::map($alurs, 'id', 'id');
$dif = array_diff($x, $alurs2);

foreach ($dif as $data) {
    $z[] = $data;
}

$item = [];
foreach($z as $alur) {
    $status1 = \app\models\Tipes::findOne($alur);
    $idstatus = $status1['id'];
    $namastatus = $status1['namatipe'];
    $item[$idstatus] = ['content' => $namastatus];    
}

$item2 = [];
foreach($alurs2 as $alur2) {
    $status2 = app\models\Tipes::findOne($alur2);
    $item2[$alur2] = ['content' => $status2['namatipe']];  
}

$form = ActiveForm::begin(); 
    
echo '<div class="row">';
echo '<div class="col-sm-6">';

echo '<p><b>All Roles</b></p>';
echo SortableInput::widget([
    'name'=>'kv-conn-1',
    'items' => $item,
    'hideInput' => true,
    'sortableOptions' => [
        //'itemOptions'=>['class'=>'alert alert-primary'], 
        'connected'=>true,
    ],
    'options' => ['class'=>'form-control', 'readonly'=>true]
]);

echo '</div>';
echo '<div class="col-sm-6">';

echo $form->field($model, 'role')->widget(SortableInput::classname(), [
    'name' => 'kv-conn-2',
    'items' => $item2,
    'hideInput' => false,
    'sortableOptions' => [
        'itemOptions'=>['class'=>'alert alert-warning'], 
        'connected'=>true,
    ],
    'options' => ['class'=>'form-control', 'readonly'=>true]
])->label('Role User');

echo Html::submitButton('Simpan', ['class' => 'btn btn-success']);
echo ' '.Html::a('Kembali', \yii\helpers\Url::previous(),['class' => 'btn btn-danger', 'title' => 'Kembali']);
echo '</div>';
echo '</div>';
ActiveForm::end(); 
?>
    
</div>