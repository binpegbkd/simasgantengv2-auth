<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\sortinput\SortableInput;

$this->title = 'Cari Data User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-cari">

<?= $this->render('_search', ['model' => $searchModel]); ?>

</div>
