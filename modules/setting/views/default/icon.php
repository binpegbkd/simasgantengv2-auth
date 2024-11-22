<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TbliconSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Icon Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblicon-index">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'responsiveWrap' => false,
        'tableOptions' => ['style' => 'font-size:10pt', 'class' => 'table table-striped table-hover'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'icon',
            [
                'attribute' => 'icon',
                'format' => 'html',
                'value' => function($dt){
                    return '<i class="fas '.$dt->icon.'"></i>&nbsp;'.$dt->icon.' (id: '.$dt->id.')';
                }
            ],
        ],
    ]); ?>


</div>
