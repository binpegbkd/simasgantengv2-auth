<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Aplikasi';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="menu-index">

<div class="row mb-2">

    <div class="ml-2 mr-auto">
        <?= Html::button('<i class="fas fa-plus-circle"></i> Tambah', ['value' => Url::to(['create']), 'title' => 'Tambah Data', 'class' => 'showModalButton btn btn-success']);?>
    </div>
    <div class="ml-auto mr-2">
        <?= Html::button('<i class="fas fa-sort-numeric-down"></i> Sort', ['value' => Url::to(['sort']), 'title' => 'Urutan Menu', 'class' => 'showModalButton btn btn-info']); ?>
    </div>
</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama_menu',
            'id',
            [
                'label' => 'Icon',
                'format' => 'raw', 
                'options' => ['style' => 'width:20%'],
                'value' => function($data) {
                    return '<i class="fas '.$data['icon'].'"></i> '.$data['icon'];
                }
            ],
            [
                'attribute' => 'link',
                'format' => 'raw', 
                'options' => ['style' => 'width:15%'],
            ],
            [
               'attribute' => 'tipe',
               'format' => 'raw',
               'value' => function($data){
                    return $data['menuTipe']['namatipe'];
                    //return Html::a($data['menuTipe']['namatipe'], ['sort','tipe' => $data->tipe], ['title' => 'Sorting']);
               },
               'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'tipe',
                    'data' => ArrayHelper::map($tipes, 'id', 'namatipe'),
                    'options' => ['placeholder' => 'Semua'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])
            ],
           /* [
               'attribute' => 'tipe',
               'label' => 'Tipe Menu'.
               'value' => 'menuTipe.namatipe',
               'filter' => Html::activeDropDownList($searchModel, 'tipe',$tipe, ['class'=>'form-control']),
            ],
            */
            
            ['class' => 'kartik\grid\ActionColumn',
                'template'  => '{update} {delete}',
                'options' => ['style' => 'width:10%;'],
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::button('<i class="fas fa-pencil-alt"></i>', ['value' => Url::to($url), 'class' => 'showModalButton btn btn-link', 'title' => 'Update']);
                    },
                ], 
            ], 
        ],
        //'summary'=>'',
    ]); ?>
</div>
