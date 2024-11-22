<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'Tambah Menu';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Menu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <?= $this->render('_form', [
        'model' => $model, 'icon' => $icon, 'tipes' => $tipes,
    ]) ?>

</div>
