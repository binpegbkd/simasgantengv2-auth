<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipes */

$this->title = 'Create Role User';
$this->params['breadcrumbs'][] = ['label' => 'Role User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipes-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
