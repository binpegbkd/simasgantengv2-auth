<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;
//echo Dialog::widget(['overrideYiiConfirm' => true]);

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
	<nav class="main-header navbar navbar-expand navbar-dark bg-info fixed-top">
		
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
			</li>
		</ul>

		<div class="navbar-nav ml-auto">
			<li class="nav-item">
				<div class="nav-link">
            		<?= Yii::$app->session['namapengguna'].' - '.Yii::$app->session['nip'];?>
            	</div>
			</li>
			<?= Html::beginForm(['/site'])
            	. Html::submitButton(
                '<i class="fas fa-arrow-circle-left"> Kembali</i>',
                ['class' => 'btn btn-danger', 'title' => 'Kembali'],
            	)
            	. Html::endForm()
			?>
		</div>&nbsp;&nbsp;
	</nav>
</header>
