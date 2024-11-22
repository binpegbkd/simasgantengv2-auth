<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;

?>

<div class="tipes-form">

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nipBaru', [
		'addon' => [
			'append' => [
				'content' => Html::button('Cari', ['class'=>'btn btn-primary']), 
				'asButton' => true
			],
		],
    ])->textInput(['id' => 'nipBaru']) ?>

    <?= $form->field($model, 'namapengguna')->textInput(['maxlength' => true, 'id' => 'namapengguna', 'readonly' => true]) ?>

    <?= $form->field($model, 'pengguna')->hiddenInput(['maxlength' => true, 'id' => 'pengguna'])->label(false) ?>


    <div class="form-group">
        <?=  Html::submitButton('<i class=\"fas fa-save\"></i> Simpan', ['class' => 'btn btn-success', 'id' => 'simpan']) ?>
        <?=  Html::a('<i class=\"fas fa-minus-circle\"></i> Batal',' ', ['class' => 'btn btn-danger', 'data-dismis' => 'modal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$urlData = Url::to(['/setting/user/get-asn']);
$script = <<< JS

$(document).ready(function(){
	if($("#nipBaru").val() != '') $("#simpan").show();
	else $("#simpan").hide();	
});

$('#nipBaru').change(function(){
	var zipId = $(this).val();
    
	$.get("{$urlData}",{ zipId : zipId },function(data){
		if (data == '' ){

            Swal.fire({
                icon: 'error',
                title: 'Gagal !!!',
                text: "Data dengan NIP "+ zipId +" tidak ditemukan !",
                showConfirmButton: false,
                timer: 2000
            })

            $("#simpan").hide();

			$('#namapengguna').attr('value','');
			$('#pengguna').attr('value','');

		}else{
            $("#simpan").show();

            var data = $.parseJSON(data);
			$('#namapengguna').attr('value',data.namapengguna);
			$('#pengguna').attr('value',data.pengguna);
		}
	});
});
JS;
$this->registerJs($script);
?>
