<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = 'Update Menu: ';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Menu', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_menu, 'url' => ['view', 'id' => $model->id_menu]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-update">

    <?= $this->render('_form', [
        'model' => $model, 'icon' => $icon, 'tipes' => $tipes,
    ]) ?>

</div>
