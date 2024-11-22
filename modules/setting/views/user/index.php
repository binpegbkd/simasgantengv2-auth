<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;

$this->title = 'Data User';
$this->params['breadcrumbs'][] = ['label' => 'Cari', 'url' => ['cari']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= Html::button('Tambah', ['value' => Url::to(['create']), 'title' => 'Tambah', 'class' => 'showModalButton btn btn-success mb-2']); ?> 
    
    <?= Html::a('<i class="fas fa-search"></i> Cari Data', '#', ['title' => 'Cari Data', 'class' => 'btn btn-primary float-right mb-2', 'id' => 'search']); ?> 

    <?= Html::a('Reset', ['reset'], ['class' => 'btn btn-outline-secondary float-right mr-2']) ?>        

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['style' => 'font-size:10pt;'],
        'summary' => '',
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'namapengguna',
                'format' => 'raw',
                'options' => ['width' => '20%;'],
                'value' => function ($data){
                    return $data['nipBaru'].'<br>'.$data['namapengguna'].'<br>'.$data['namaopd'];

                }
            ],
            [
                'attribute' => 'username',
                'format' => 'raw',
                'options' => ['width' => '15%;'],
                'value' => function ($data){                   
                    return "(".$data['id'].")<br>".$data['username'];

                }
            ],
            [
                'attribute' => 'role',
                'format' => 'raw',
                'options' => ['width' => '20%;'],
                'value' => function ($data){
                    $role = \app\models\RoleUser::getRole($data['id']);
                    $x ='';
                    foreach($role as $key => $val){
                        $tipe = \app\models\Tipes::findOne($val);
                        if($tipe !== null){
                            if($key == 0)  $x = $tipe['namatipe'];
                            else $x = $x.', '.$tipe['namatipe'];
                        }
                    }
                    return $x;
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'options' => ['width' => '10%;'],
                'value' => function ($data){
                    if($data['status'] == 10) return 'aktif'; else return '<b style="color:red;">non aktif</b>';
                }
            ],
            [
                'attribute' => 'flag',
                'label' => 'Ket',
                'options' => ['width' => '10%;'],
                'format' => 'raw',
                'value' => function ($data){
                    if($data['flag'] == 0) 
                    return '<b style="color:red;">password default</b>'; 
                    else return 'password updated';
                }
            ],
            [
                'attribute' => 'updateby',
                'label' => 'Terakhir diubah oleh',
                'options' => ['width' => '20%;'],
                'format' => 'raw',
                'value' => function ($data){   
                    return $data['updateby'].'<br>'.$data['modified'];
                }
            ],
            [
                'header' => 'Action',
                'format' => 'raw',
                'headerOptions' => ['width:10%'],
                'contentOptions' => ['style' => 'text-align:right; font-size:12px;'],
                'value' => function($dt){
                    if($dt['status'] == 9) {
                        
                        $list = Html::a('<span class="fas fa-trash-restore-alt"></span> Restore', ['user-aktif', 'id' => $dt['id']],['class' => 'tombol-aktif button dropdown-item']);
                    
                    }else{
                        $list = Html::button('<span class="fas fa-home"></span> Unit Kerja', ['value' => Url::to(['unor', 'id' => $dt['id']]),'class' => 'showModalButton dropdown-item']).'

                        '.Html::button('<span class="fas fa-user-cog"></span> Role User', ['value' => Url::to(['roles', 'id' => $dt['id']]),'class' => 'showModalButton dropdown-item']).'
                        
                        '.Html::a('<span class="fas fa-undo"></span> Reset Default', ['default-password', 'id' => $dt['id']],['class' => 'tombol-reset button dropdown-item']).'
                        
                        '.Html::a('<span class="fas fa-trash-alt"></span> Hapus', ['delete', 'id' => $dt['id']], ['class' => 'tombol-hapus button dropdown-item']);
                    }

                    $tombol = '<div class="dropdown">
                        <button class="btn-sm btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Update Data
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            '.$list.'
                        </div>
                    </div>';
                    
                    return $tombol;
                },
            ],
            /*
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{roles} {delete} {default-password} {user-aktif}',
                'options' => ['width' => '5%;'],
                'buttons' => [
                    'roles' => function ($url) {
                        //return Html::button('<span class="fas fa-user-cog"></span>', ['class' => 'btn btn-link', 'onclick' => 'document.location.href = "'.Url::to($url).'";']);

                        return Html::button('<span class="fas fa-user-cog"></span>', ['value' => Url::to($url), 'class' => 'showModalButton btn btn-link']);
                    },
                    'delete' => function ($url) {
                        return Html::a('<span class="fas fa-trash-alt"></span>', $url, [
                            'title' => 'Hapus',
                            'class' => 'tombol-hapus',
                            'data-method' => 'post',
                        ]);
                    },
                    'default-password' => function ($url, $model) {
                        return Html::a('<span class="fas fa-undo"></span>', $url, [
                            'title' => 'Reset to default password',
                            'class' => 'tombol-reset',
                            'data-method' => 'post',
                        ]);
                    },
                    'user-aktif' => function ($url, $model) {
                        return Html::a('<span class="fas fa-check"></span>', $url, [
                            'title' => 'Aktifkan User',
                            'class' => 'tombol-aktif',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],   
            */         
        ],
    ]); ?>

</div>

<div id="cari-block" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <h5 class="modal-title">Cari Data</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php echo $this->render('_search', ['model' => $searchModel, 'opd' => $opd, 'roles' => $roles]); ?>
            </div>
        </div>
    </div>
</div>


<?php
    Modal::begin([
        'title' => Html::encode($this->title),
        'headerOptions' => ['class' => 'bg-primary'],
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";
    Modal::end();

    $script = <<< JS

    $('#search').click(function(){
        $("#cari-block").modal('show');
    });

    JS;
    $this->registerJs($script);
?>