<?php

namespace app\modules\setting\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\SignupForm;
use app\models\ResetPassword;
use app\models\Fungsi;
use app\models\Filter;
use app\models\Tipes;
use app\models\Tblasn;
use app\models\Tbltablokb;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback'=>function(){
                            return (
                                Yii::$app->session['roleadmin']==1
                            );
                        },
                    ],
                ],                   
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {       
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['status' => SORT_DESC, 'username' => SORT_ASC]);

        $opd = Tbltablokb::find()
        ->select(['KOLOK', 'NALOK', 'CONCAT("KOLOK",\' \',"NALOK") AS OPD'])
        ->asArray()
        ->orderBy(['KOLOK' => SORT_ASC])->all();

        $roles = Tipes::find()->where(['>', 'id', 1])->orderBy(['namatipe' => SORT_ASC])->all();

        Url::remember();
        //$this->layout = '//main-set';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'opd' => $opd,
            'roles' => $roles,
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $validasi = User::find()->where(['nipBaru' => $model['nipBaru']])->one();
            if($validasi !== null){
                Yii::$app->session->setFlash('position', [
                    'icon' => \dominus77\sweetalert2\Alert::TYPE_ERROR,
                    'title' => 'Gagal',
                    'text' => 'User '.$model['nipBaru'].' sudah ada atas nama '.$model['namapengguna'],
                    'showConfirmButton' => false,
                    'timer' => 2000
                ]); 
                return $this->redirect(Url::previous());
            }
            
            $count = User::find()->orderBy(['id' => SORT_DESC])->one();
            if($count['id'] === null) $model['id'] = 1;
            else $model['id'] = $count['id'] + 1;

            $model->setPassword(substr($model['nipBaru'],0,8));
            $model->generateAuthKey();
            $model['modified'] = date('Y-m-d H:i:s');
            $model['flag'] = 0;
            $model['role'] = 2;
            $model['status'] = 10;
            $model['updateby'] = Yii::$app->session['nip'].'-'.Yii::$app->session['namapengguna'];
            $model->username = $model['nipBaru'];
            
            if($model->save(false)) {
                Yii::$app->session->setFlash('position', [
                    'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                    'title' => 'Berhasil',
                    'text' => 'Data berhasil disimpan',
                    'showConfirmButton' => false,
                    'timer' => 2000,
                ]);   
            }else{
                Yii::$app->session->setFlash('position', [
                    'icon' => \dominus77\sweetalert2\Alert::TYPE_ERROR,
                    'title' => 'Gagal',
                    'text' => 'Data gagal disimpan',
                    'showConfirmButton' => false,
                    'timer' => 2000
                ]); 
            }
            return $this->redirect(Url::previous());
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('tambah', [
                'model' => $model, 
            ]);
        }else{
            return $this->render('tambah', [
                'model' => $model, 
            ]);
        }
    }

    public function actionReset(){
        return $this->redirect(['index']);
    }

    public function actionRoles($id)
    {
        $model = $this->findModel($id);
        $model['updateby'] = Yii::$app->session['nip'].' '.Yii::$app->session['namapengguna'];

        //$this->layout = '//main-set';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('position', [
                'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                'title' => 'Success',
                'text' => 'Role pengguna/ user baru berhasil diubah',
                'showConfirmButton' => false,
                'timer' => 2000,
            ]);
            return $this->redirect(Url::previous());
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('role', [
                'model' => $model, 
            ]);
        }else{
            return $this->render('role', [
                'model' => $model, 
            ]);
        } 
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 9;
        $model['updateby'] = Yii::$app->session['nip'].' '.Yii::$app->session['namapengguna'];
        $model->save(false);
        Yii::$app->session->setFlash('position', [
            'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
            'title' => 'Success',
            'text' => 'Data pengguna/ user baru berhasil dinonaktifkan',
            'showConfirmButton' => false,
            'timer' => 2000,
        ]);

        return $this->redirect(Url::previous());
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDefaultPassword($id)
    {
        $model = $this->findModel($id);
        User::defaultPassword($id);
        Yii::$app->session->setFlash(
            'position', [
                'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                'title' => 'Success',
                'text' => 'Reset default username dan password telah dilakukan',
                'showConfirmButton' => false,
                'timer' => 2000,
            ]);   
        return $this->redirect(Url::previous());
    }  

    public function actionGetAsn($zipId){
        $fip = Tblasn::find()->where(['nipBaru' => $zipId])->one();  
        if($fip === null) $data = '';
        else{  
            $data = [
                "nipBaru" => $fip['nipBaru'],
                "namapengguna" => $fip['nama'],
                "pengguna" => $fip['id'],    
            ];
            return Json::encode($data);
        }
 
    }

    public function actionUserAktif($id)
    {
        $model = $this->findModel($id);
        $model->status = 10;
        $model->save(false);
        Yii::$app->session->setFlash(
            'position', [
                'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                'title' => 'Success',
                'text' => 'Username dengan NIP '.$model['nipBaru'].'telah diaktifkan',
                'showConfirmButton' => false,
                'timer' => 2000,
            ]);   
        return $this->redirect(Url::previous());
    }  

    public function actionUnor($id)
    {
        $model = $this->findModel($id);
        $model['updateby'] = Yii::$app->session['nip'].' '.Yii::$app->session['namapengguna'];
        $opd = Tbltablokb::find()
        ->select(['KOLOK', 'NALOK', 'CONCAT("KOLOK",\' \',"NALOK") AS OPD'])
        ->asArray()
        ->orderBy(['KOLOK' => SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('position', [
                'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                'title' => 'Success',
                'text' => 'Role pengguna/ user baru berhasil diubah',
                'showConfirmButton' => false,
                'timer' => 2000,
            ]);
            return $this->redirect(Url::previous());
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('unor', [
                'model' => $model, 'opd' => $opd
            ]);
        }else{
            return $this->render('unor', [
                'model' => $model, 'opd' => $opd
            ]);
        } 
    }
}
