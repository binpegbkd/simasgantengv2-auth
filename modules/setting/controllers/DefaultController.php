<?php

namespace app\modules\setting\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Tblicon;
use app\models\TbliconSearch;

/**
 * Default controller for the `setting` module
 */
class DefaultController extends Controller
{
    public function behaviors(){
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
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //$this->layout = '//main-set';
        $data = [];
        $data['user_aktif'] = $this->getData('status', 10);
        $data['user_pasif'] = $this->getData('status', 9);
        $data['user_update_pass'] = $this->getData('flag', 1);
        $data['user_defa_pass'] = $this->getData('flag', 0);
        
        return $this->render('index',['data' => $data]);
    }

    protected function getData($fil, $val){
        $query = \app\models\User::find()
        ->select(['status', 'flag'])
        ->where([$fil => $val])
        ->count()
        ;

        return $query;
    }  

    public function actionIcon()
    {
        $searchModel = new TbliconSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //$this->layout = '//main-set';
        return $this->render('icon', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
