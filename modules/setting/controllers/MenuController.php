<?php

namespace app\modules\setting\controllers;

use Yii;
use app\models\Menu;
use app\models\MenuSearch;
use app\models\Filter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Menu models.
     * @return mixed
     */
    
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['urutan' => SORT_ASC]];
        $tipes = $this->findTipes();

        Url::remember();
        //$this->layout = '//main-set';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tipes' => $tipes,
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $nom = Menu::find()->select(['id'])->orderBy(['id' => SORT_DESC])->one();
        $num = $nom['id'] + 1;

        $model = new Menu();
        $icon = $this->findIcon();
        $tipes = $this->findTipes();
        //$this->layout = '//main-set';

        if ($model->load(Yii::$app->request->post())) {
            $model['id'] = $num;
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
            return $this->renderAjax('create', [
                'model' => $model, 'icon' => $icon, 'tipes' => $tipes,
            ]);
        }else{
            return $this->render('create', [
                'model' => $model, 'icon' => $icon, 'tipes' => $tipes,
            ]);
        }    
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $icon = $this->findIcon();
        $tipes = $this->findTipes();
        //$this->layout = '//main-set';

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->session->setFlash('position', [
                'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                'title' => 'Berhasil',
                'text' => 'Data berhasil disimpan',
                'showConfirmButton' => false,
                'timer' => 2000,
            ]);  
            //return $this->redirect(['index']);
            return $this->redirect(Url::previous());
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model, 'icon' => $icon, 'tipes' => $tipes,
            ]);
        }else{
            return $this->render('update', [
                'model' => $model, 'icon' => $icon, 'tipes' => $tipes,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('position', [
            'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
            'title' => 'Berhasil',
            'text' => 'Data berhasil dihapus',
            'showConfirmButton' => false,
            'timer' => 2000,
        ]);  
        //return $this->redirect(['index']);
        return $this->redirect(Url::previous());
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {       
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findIcon()
    {
        $icon = \app\models\Tblicon::find()
        //->select(["id", "CONCAT('<i class=\"fas icon\"></i> ', icon) AS iconmen"])
        ->all();
        return $icon;    
    }

    protected function findTipes()
    {
        $tipes = \app\models\Tipes::find()->where(['<>','id', 1])->all();
        return $tipes;
    }

    public function actionSort()
    {
        $model = Menu::find()->orderBy(['urutan' => SORT_ASC]);
        $urutan = [];
        foreach($model->all() as $sort){
            $urutan[$sort['id']] = ['content' => $sort['nama_menu']];
        }

        if (Yii::$app->request->post()) {
            $req = explode(',', Yii::$app->request->post("sort"));
            $i = 0;
            foreach($req as $urut){
                $i = $i+1;
                $data = $this->findModel($urut);
                $data['urutan'] = $i;
                $data->save();
            }
            Yii::$app->session->setFlash('position', [
                'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                'title' => 'Berhasil',
                'text' => 'Menu berhasil diurutkan',
                'showConfirmButton' => false,
                'timer' => 2000,
            ]);  
            return $this->redirect(Url::previous());
        }
        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('sort', [
                'model' => $model, 'urutan' => $urutan,
            ]);
        }else{
            return $this->render('sort', [
                'model' => $model, 'urutan' => $urutan,
            ]);
        }
    } 
    
}
