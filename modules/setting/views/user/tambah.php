<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Tambah User';
$this->params['breadcrumbs'][] = ['label' => 'Cari', 'url' => ['cari']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form-add', [
        'model' => $model,
    ]) ?>

</div>
