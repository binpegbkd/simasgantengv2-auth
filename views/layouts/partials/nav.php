<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use app\widgets\Menu;

?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-primary">
	<!-- Brand Logo -->
	  <a href="<?= Yii::$app->homeUrl; ?>" class="brand-link">
      <img src="<?= Yii::getAlias('@web')?>/brebes.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-dark"><?= ucwords(Html::encode(Yii::$app->name)); ?></span>
    </a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
      <?= Menu::widget([
					'options' => [
						'class' => 'nav nav-pills nav-sidebar flex-column',
						'data-widget' => 'treeview',
						'role' => 'menu',
						'style' => 'word-wrap : break-word;font-size:12pt;',
						'data-accordion' => true,
					],
					'items' => [
            ['label' => 'Pengaturan', 'url' => Url::to(['/setting']), 'icon' => 'fas fa-cogs'],
            ['label' => 'Tipe User', 'url' => Url::to(['/setting/tipe']), 'icon' => 'fas fa-user-cog'],
            ['label' => 'Icon List', 'url' => Url::to(['/setting/icon']), 'icon' => 'fas fa-icons'],
            ['label' => 'Menu Aplikasi', 'url' => Url::to(['/setting/menu']), 'icon' => 'fas  fa-clipboard-list'],
            ['label' => 'Data User', 'url' => Url::to(['/setting/user']), 'icon' => 'fas fa-users'],
          ],
      ]);?>
		</nav>
	</div>

</aside>

<?php
$css = <<< CSS
.img {
      background:  #fcf3cf;
      position: relative;
      text-align: center;
      transform: rotate(10deg);

    }
.img2{     
      position: relative;
      text-align: center;
      transform: rotate(-10deg);

    }      
    
CSS;
$this->registerCss($css);
?>
