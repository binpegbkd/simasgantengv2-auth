<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Tipe User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipes-index">

<div class="row">
    <div class="ml-2 mr-auto mb-2">
        <?= Html::button('<i class="fas fa-plus-circle"></i> Tambah', ['value' => Url::to(['create']), 'title' => 'Tambah', 'class' => 'showModalButton btn btn-success']); ?>
    </div>
</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover'],
        'summary' => '',
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'namatipe',
            'id',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}',
                //'options' => ['style' => 'width:50%'],
                'buttons' => [
                    'update' => function ($url) {
                        return Html::button('<span class="fas fa-pencil-alt"></span>',['value' => Url::to($url), 
                            'title' => 'Tipe User', 'class' => 'showModalButton btn btn-link',
                        ]);
                    },
                ], 
            ],
        ],
    ]); ?>


</div>
