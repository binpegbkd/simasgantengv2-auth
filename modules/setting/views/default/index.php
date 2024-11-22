<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TbliconSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengaturan';
$this->params['breadcrumbs'][] = $this->title;

$jml = $data['user_aktif'] + $data['user_pasif'];
?>

<div class="setting-default-index">

    <div class="row">
        <?= Card(4, 'light', 'success', 'fa-users', 'Jumlah User', $jml, 0) ?>
        <?= Card(4, 'light', 'info', 'fa-users', 'Jumlah User Aktif', $data['user_aktif'], ($data['user_aktif']/$jml*100)) ?>
        <?= Card(4, 'light', 'warning', 'fa-users', 'Jumlah User Non Aktif', $data['user_pasif'], ($data['user_pasif']/$jml*100)) ?>
               
    </div>

    <div class="row">
        <?= Card(4, 'light', 'secondary', 'fa-key', 'User Update Password', $data['user_update_pass'], ($data['user_update_pass']/$jml*100)) ?>
        <?= Card(4, 'light', 'danger', 'fa-key', 'User Default Password', $data['user_defa_pass'], ($data['user_defa_pass']/$jml*100)) ?>
               
    </div>
    
</div>


<?php
function Card($row, $warna, $bg, $icon, $text, $val, $persen){
    if($persen == 0) $nilai = number_format($val, '0', ',', '.');
    else $nilai = number_format($val, '0', ',', '.')." ( ". number_format($persen, '2', ',', '.'). "% )";

    echo "<div class=\"col-12 col-sm-6 col-md-$row\">
    <div class=\"info-box bg-$warna\">
        <span class=\"info-box-icon bg-$bg elevation-1\"><i class=\"fas $icon\"></i></span>
        <div class=\"info-box-content\">
            <span class=\"info-box-text\">$text</span>
            <span class=\"info-box-number\">$nilai</span>
        </div>
    </div>
</div>";
}

?>
