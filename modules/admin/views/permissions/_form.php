<?php
/* @var $this \yii\web\View */
/* @var $model \justcoded\yii2\rbac\forms\PermissionForm */
/* @var $permission \justcoded\yii2\rbac\models\Permission */
/* @var $relModel PermissionRelForm */

use justcoded\yii2\rbac\forms\PermissionRelForm;
use yii\helpers\Html;
use justcoded\yii2\rbac\widgets\RbacActiveForm;
use justcoded\yii2\rbac\forms\ItemForm;

?>

<div class="row">
	<div class="col-md-6">
		<?php $form = RbacActiveForm::begin([
			'id' => 'form-permission',
		]); ?>
		<div class="panel box card">
			
			<div class="panel-body box-body card-body">

				<?= $form->field($model, 'name')->textInput([
					'maxlength' => true,
					'readonly'  => $model->scenario != ItemForm::SCENARIO_CREATE
				]) ?>

				<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'ruleClass')->textInput() ?>

			</div>
			<div class="panel-footer box-footer card-footer text-right">
				<?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?> &nbsp;
				<?= Html::a('Batal',\yii\helpers\Url::previous(), ['class' => 'btn btn-danger']) ?>
				<?php /*if (!empty($permission)) : ?>
					<?= Html::a(
						'Hapus',
						['delete', 'name' => $model->name],
						[
							'class' => 'btn btn-danger',
							'data' => [
								'confirm' => 'Are you sure you want to delete this item?',
								'method' => 'post',
							],
						]
					) ?>
				<?php endif;*/ ?>
			</div>
		</div>
		<?php $form::end(); ?>

		<?php if (!empty($permission)) : ?>
		<p class="text-center">
			<br>
			<?= Html::a('Add another permission', ['permissions/create'], ['class' => 'btn btn-info']); ?>
		</p>
		<?php endif; ?>
	</div>

	<?php if (!empty($permission)) : ?>
	<div class="col-md-6">
		<?php

		$relModel->scenario = PermissionRelForm::SCENARIO_ADDROLE;
		echo $this->render('_relations-box', [
			'title' => 'Asigned Roles',
			'relModel' => $relModel,
			'model' => $model,
			'introMsg' => 'Permission is assigned to such roles:',
			'emptyMsg' => 'Permission is not assigned to any roles.',
			'searchMsg' => 'Search roles...',
			'options' => \justcoded\yii2\rbac\models\Role::getList(),
			'opposite' => [],
			'selected' => $permission->getRoles(),
			'btnTxt' => 'Assign',
		]);

		$relModel->scenario = PermissionRelForm::SCENARIO_ADDPARENT;
		echo $this->render('_relations-box', [
			'title' => 'Parents',
			'relModel' => $relModel,
			'model' => $model,
			'introMsg' => 'Permission is a <b>child</b> of such permissions:',
			'emptyMsg' => 'Permission doesn\'t have parents.',
			'searchMsg' => 'Search permissions...',
			'options' => \justcoded\yii2\rbac\models\Permission::getList(),
			'opposite' => $permission->getChildren(),
			'selected' => $permission->getParents(),
			'btnTxt' => 'Add Parents',
		]);

		$relModel->scenario = PermissionRelForm::SCENARIO_ADDCHILD;
		echo $this->render('_relations-box', [
			'title' => 'Children',
			'tableOptions' => ['style' =>'font-size:10pt;'],
			'relModel' => $relModel,
			'model' => $model,
			'introMsg' => 'Permission is a <b>parent</b> of such permissions:',
			'emptyMsg' => 'Permission doesn\'t have children.',
			'searchMsg' => 'Search permissions...',
			'options' => \justcoded\yii2\rbac\models\Permission::getList(),
			'opposite' => $permission->getParents(),
			'selected' => $permission->getChildren(),
			'btnTxt' => 'Add Childs',
		]); ?>
	<?php endif; ?>
</div>

