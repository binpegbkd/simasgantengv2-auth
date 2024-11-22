<?php
/* @var $this \yii\web\View */
/* @var $model \justcoded\yii2\rbac\forms\RoleForm */
/* @var $role \justcoded\yii2\rbac\models\Role */

use justcoded\yii2\rbac\models\Role;
use yii\helpers\Html;
use justcoded\yii2\rbac\widgets\RbacActiveForm;
use justcoded\yii2\rbac\forms\ItemForm;
use justcoded\yii2\rbac\assets\RbacAssetBundle;

RbacAssetBundle::register($this);
?>

<?php $form = RbacActiveForm::begin(); ?>
	
	<div id="justcoded-role-form" class="panel-body box-body card-body">
		<?= $form->field($model, 'name')->textInput([
			'maxlength' => true,
			'readonly'  => $model->scenario != ItemForm::SCENARIO_CREATE
		]) ?>

		<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'childRoles')
				->inline()
				->checkboxList(array_diff(Role::getList(), [$model->name]), [
					'value' => $model->childRoles,
				])
		?>

		<?= $this->render('_permissions', [
				'model' => $model,
				'form'  => $form,
		]) ?>
	</div>
	<div class="panel-footer box-footer card-footer text-right">
		<?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?> &nbsp;
		<?= Html::a('Batal',\yii\helpers\Url::previous(), ['class' => 'btn btn-danger']) ?>
		<?php /*if (!empty($role)) : ?>
			<?= Html::a(
				'Hapus',
				['delete', 'name' => $model->name],
				[
					'class' => 'btn btn-danger',
					'data'  => [
						'confirm' => 'Apakah Anda yakin akan menghapus item ini?',
						'method'  => 'post',
					],
				]
			) ?>
		<?php endif;*/ ?>
	</div>

<?php $form::end(); ?>
