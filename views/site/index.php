<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Beranda';

?>
<div class="site-index">
  <div class="row">
    <div class="col-lg-12">
      <center>
        <h1 class="btn-lg btn-danger">Beberapa fitur pada sistem ini masih dalam tahap pengembangan dan uji coba</h1>
      <center>
    <div>
  </div>
    <div class="row">
      <?php 
        $dt['urutan'] = 1;
        foreach($data as $dt): 
          switch($dt['urutan']%4){
            case 0:  $clas = 'purple'; break;
            case 1:  $clas = 'blue'; break;
            case 2:  $clas = 'orange'; break;
            case 3:  $clas = 'green'; break;
          }
      ?>
          <div class="col-lg-3 col-md-6">        
            <?= Html::a("<div class='service-box ".$clas."'>
                <i class='ri-discuss-line icon'>
                  <i class='fas ".$dt['icon']."'>
                  </i>
                </i><h3>".$dt['namamenu']."</h3><br></div>", 
                Url::to(['menu-forward', 'id' => $dt['link'], 'name' => $dt['idmenu'], 'auth'=>$dt['tipe']]),
                ['data-method' => 'post'])?>
          </div>
      <?php 
        $urutan = $dt['urutan'] + 1;
        endforeach;

        switch($urutan%4){
          case 0:  $clas = 'purple'; break;
          case 1:  $clas = 'blue'; break;
          case 2:  $clas = 'orange'; break;
          case 3:  $clas = 'green'; break;
        }
        if(Yii::$app->session['roleadmin'] == 1) :
      ?>

        <div class="col-lg-3 col-md-6">
          <a href="<?= Url::to(['/setting'])?>">
            <div class="service-box <?= $clas ?>">
              <i class="ri-discuss-line icon"><i class="fas fa-cogs"></i></i>
              <h3>Pengaturan</h3>
            </div>
          </a>
          </div>
      <?php endif; ?>    
    </div>    
  &nbsp;



</div>
