<?php

use yii\helpers\Html;
use justcoded\yii2\rbac\models\ItemSearch;
use justcoded\yii2\rbac\forms\RoleForm;
//use justcoded\yii2\rbac\widgets\RbacGridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel justcoded\yii2\rbac\models\ItemSearch */
/* @var $dataProviderPermissions yii\data\ActiveDataProvider */
/* @var $dataProviderRoles yii\data\ActiveDataProvider */

$this->title = 'Permission';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="permission-index">
	<div class="row">
		<div class="col-md-8">
			<div class="panel box">
				<div class="panel-header box-header with-border">
					<h4 class="box-title">Roles
						&nbsp;
						<?= Html::a('Add Role', ['roles/create'], ['class' => 'btn btn-sm btn-success']); ?>
					</h4>
				</div>
				<div class="panel-body box-body">
					<?= GridView::widget([
						'dataProvider' => $dataProviderRoles,
						'filterModel'  => $searchModel,
						//'tableOptions' => ['class' => 'table table-striped table-hover', 'style' => 'font-size:10pt'],
						'columns'      => [
							['class' => 'yii\grid\SerialColumn'],
							[
								'header'    => 'Role',
								'headerOptions' => ['class' => 'col-md-5'],
								'format'    => 'raw',
								'filter'    => Html::activeTextInput($searchModel, 'roleName', ['class' => 'form-control']),
								'value'     => function ($data) {
									return Html::a($data->name, ['roles/update', 'name' => $data->name],['title' => 'Update'])
										.' '. Html::a(
											'<i class="fas fa-trash-alt"></i>',
											['roles/delete', 'name' => $data->name],
											[
												'class' => 'text-danger',
												'title' => 'Hapus',
												'data'  => [
													'confirm' => 'Anda yakin akan menghapus role <em><b>'.$data->name.'</b></em> ?',
													'method'  => 'post',
												],
											]
										)
									    . '<br>' . Html::encode($data->description);
								},
							],
							[
								'header' => 'Permissions',
								'headerOptions' => ['class' => 'col-sm-2 text-center'],
								'contentOptions' => ['class' => 'text-center'],
								'value'  => function ($data) {
									return count(Yii::$app->authManager->getPermissionsByRole($data->name));
								},
							],
							[
								'header' => 'Inherit',
								//'headerOptions' => ['class' => 'col-md-5'],
								'value'  => function ($data) {
									return implode(', ', ItemSearch::getInherit($data->name));
								},
							]
						],
					]); ?>
				</div>
			</div>
		</div>

		<div class="col-md-4">&nbsp;</div>

		<div class="col-lg-12">
			<div class="panel box">
				<div class="panel-header box-header with-border">
					<h4 class="box-title">Permissions
						&nbsp;
						<?= Html::a('Add Permission', ['permissions/create'], ['class' => 'btn btn-sm btn-success']); ?>
						<?= Html::a('Scan Routes', ['permissions/scan'], ['class' => 'btn btn-sm btn-info']); ?>
					</h4>
				</div>
				<div class="panel-body box-body">
					<?= GridView::widget([
						'dataProvider' => $dataProviderPermissions,
						'filterModel'  => $searchModel,
						//'tableOptions' => ['class' => 'table table-striped table-hover', 'style' => 'font-size:10pt'],
						'columns'      => [
							['class' => 'yii\grid\SerialColumn'],
							[
								'header'    => 'Permission',
								//'format'    => 'html',
								'format'    => 'raw',
								'filter'    => Html::activeTextInput($searchModel, 'permName', ['class' => 'form-control']),
								'value'     => function ($data) {
									return Html::a($data->name, ['permissions/update', 'name' => $data->name],['title' => 'Update'])
										.' '.Html::a(
											'<i class="fas fa-trash-alt"></i>',
											['permissions/delete', 'name' => $data->name],
											[
												'class' => 'text-danger',
												'title' => 'Hapus',
												'data'  => [
													'confirm' => 'Anda yakin akan menghapus permission <em><b>'.$data->name.'</b></em> ?',
													'method'  => 'POST',
												],
											]
										);
								}
							],
							[
								'attribute' => 'description',
							],
							[
								'header' => 'Roles',
								'format' => 'html',
								'headerOptions' => ['class' => 'col-md-2'],
								'filter'    => Html::activeDropDownList($searchModel, 'permRole', \justcoded\yii2\rbac\models\Role::getList(),
									['class' => 'form-control', 'prompt' => 'Any']
								),
								'value'  => function ($data) {
									return implode(', ', ItemSearch::getRoleByPermission($data->name));
								}
							]
						],
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>