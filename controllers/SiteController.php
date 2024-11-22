<?php

namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Json;
use app\models\LoginForm;

use dominus77\sweetalert2\Alert;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'error', 'login', 'sign-out', 'update-password'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['error', 'index', 'login', 'sign-out', 'update-password', 'keluar'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'sign-out' => ['post'],
                    'menu-forward' => ['post'],
                    'keluar' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                //'class' => 'yii\web\ErrorAction',
                'class' => 'app\widgets\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 4,
                'minLength' => 5,
                'padding' => 1,
                'fontFile' => '@yii/captcha/3dfont.ttf',
                'height' => 70,
                'width' => 200,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {         
        if (Yii::$app->user->isGuest) return $this->redirect(['/site/login']);

        if (Yii::$app->session['iduser'] === null){
            Yii::$app->session->destroy();
            Yii::$app->cache->flush();
            Yii::$app->user->logout();
            return $this->goHome();
        } 

        if(Yii::$app->user->identity->flag == 0) return $this->redirect(['/site/update-password']);

        $role = \app\models\RoleUser::getRole(Yii::$app->session['iduser']);
        $data = [];
        foreach($role as $key => $val){
            $menu = \app\models\Menu::find()
            ->where(['tipe' => $val])
            ->orderby(['urutan' => SORT_ASC])
            ->all();
            foreach($menu as $men){
                $data[] = [
                    'idmenu' => $men['id'],
                    'namamenu' => $men['nama_menu'],   
                    'urutan' => $men['urutan'],
                    'icon' => $men['icon'],
                    'link' => $men['link'],
                    'tipe' => $men['tipe'],
                ];
            }
        }
        
        $urutan = array_column($data, 'urutan');

        array_multisort($urutan, SORT_ASC, $data);
        Url::remember();

        $this->layout = '//main-indeks';
        return $this->render('index',['data' => $data]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            if(Yii::$app->user->identity->flag == 0) return $this->redirect(['/site/update-password']);
            return $this->goHome();
        }

        $this->layout = '//main-login';
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            $session = Yii::$app->session;
            $session['password'] = $model['password'];
            $session['username'] = $model['username'];
            $session['nip'] = Yii::$app->user->identity->nipBaru; 
            $session['pengguna'] = Yii::$app->user->identity->pengguna;
            $session['namapengguna'] = Yii::$app->user->identity->namapengguna;
            $session['iduser'] = Yii::$app->user->identity->id;
            $session['roleadmin'] = \app\models\RoleUser::getRoleAdmin($session['iduser']);
            $session['tablokb'] =  Yii::$app->user->identity->tablok;
            
            $log_model = new \app\models\Tbllog();
            $log_model['id'] = $session['nip'].'-'.time();
            $log_model['login'] = date('Y-m-d H:i:s');
            $log_model->save();

            $gettoken = \app\models\User::findOne(Yii::$app->user->identity->id);
            $token = Yii::$app->security->generatePasswordHash($gettoken->username.time());
            $gettoken->token_id = $token;
            $gettoken->token_expired = date('Y-m-d H:i:s', time()+3600*3);
            $gettoken->save();
        
            $session['log'] = $log_model['id']; 
            // $session['token_id'] = Yii::$app->user->identity->token_id;
            // $session['token_expired'] = Yii::$app->user->identity->token_expired;
            $session['token_id'] = $gettoken->token_id;
            $session['token_expired'] = $gettoken->token_expired;

            return $this->goBack();
        }
        
        //$model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignOut()
    {          
        $this->layout = '//main-indeks';
        $session = Yii::$app->session;
        $log_model = \app\models\Tbllog::findOne($session['log']);
        $log_model['logout'] = date('Y-m-d H:i:s');
        $log_model->save();

        Yii::$app->session->destroy();
        Yii::$app->cache->flush();
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionKeluar()
    {          
        $this->layout = '//main-indeks';
        Yii::$app->session->destroy();
        Yii::$app->cache->flush();
        Yii::$app->user->logout();        
        return $this->goHome();
    }

    public function actionLogout()
    {  
        $this->layout = '//main-indeks';
        $urlData = Url::to(['/site/sign-out']);
        Yii::$app->session->setFlash('confirm', [
            'title' => 'Yakin Keluar?',
            'text' => "Keluar dari sistem ini !",
            'icon' => Alert::TYPE_QUESTION,
            'showCancelButton' => true,
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33',
            'confirmButtonText' => 'Ya, Keluar!',
            'cancelButtonText' => 'Batal',
            'callback' => new \yii\web\JsExpression("
                (result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title : 'Terima Kasih',
                            text : 'Anda telah menggunakan sistem ini.',
                            icon : 'success',
                            showConfirmButton : false,
                            timer : 1000
                        });
                        $.post('{$urlData}');
                    }
                }
            ")
        ]);
        return $this->goBack();
    }

    public function actionUpdatePassword()
    {
        if(Yii::$app->user->identity->flag == 1) return $this->redirect(['index']);
        
        $this->layout = '//main-pass';
        $session = Yii::$app->session;
        
        $id = Yii::$app->user->identity->id;
        $model = \app\models\User::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $str = Yii::$app->request->post('User')['password'];
            $model['username'] = Yii::$app->request->post('User')['username'];
           
            if(preg_match('/[A-Z]/', $str) && preg_match('/[a-z]/', $str) && preg_match('~[0-9]+~', $str)) {
                $model->setPassword($str);
                $model['updateby'] = $session['nip'].'-'.$session['namapengguna'];
                $model['modified'] = date('Y-m-d H:i:s');
                $model['flag'] = 1;
                if($model->save(false)){
                    $urlData = Url::to(['/site/keluar']);
                    Yii::$app->session->setFlash('position', [
                        'icon' => \dominus77\sweetalert2\Alert::TYPE_SUCCESS, 
                        'title' => 'Berhasil',
                        'text' => 'Username/ password berhasil diubah, silahkan login ulang',
                        'confirmButtonText' => 'Oke...!',
                        'callback' => new \yii\web\JsExpression("
                            (result) => {
                                if (result.isConfirmed) {
                                    $.post('{$urlData}');
                                }
                            }
                        ")
                    ]); 
                }else{
                    Yii::$app->session->setFlash('position', [
                        'icon' => \dominus77\sweetalert2\Alert::TYPE_ERROR,
                        'title' => 'Gagal',
                        'text' => 'Username/ password gagal diubah',
                        'showConfirmButton' => false,
                        'timer' => 1000
                    ]); 
                }
            }else{
                Yii::$app->session->setFlash('position', [
                    'icon' => \dominus77\sweetalert2\Alert::TYPE_ERROR,
                    'title' => 'Kombinasi password tidak sesuai',
                    'text' => 'Password harus memuat huruf besar, huruf kecil dan angka atau sesuaikan dengan password MyASN - BKN.',
                    'showConfirmButton' => true,
                    //'timer' => 1000
                ]); 
            }
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('update-pass', [
                'model' => $model, 
            ]);
        }else{
            return $this->render('update-pass', [
                'model' => $model, 
            ]);
        } 
    }

    public function actionMenuForward($id, $name, $auth)
    {
        $post = Yii::$app->request->post('_csrf-app');

        $sess = Yii::$app->session;
        $token = $sess['token_id'];

        $uname = base64_encode($this->enkripsi($sess['username'],$token));
        $pass = base64_encode($this->enkripsi($sess['password'],$token));
        $role = base64_encode($auth).$token;

        //if(substr($sess['tablokb'],0,4) == '3100') $id = $id;

        $url = $id."/web/login?name=$name&role=$role&token=$token&id=$uname&key=$pass"; 
        Yii::$app->response->redirect($url, 301);
        //Yii::$app->end();
    }
    
    protected function enkripsi($name, $key){
        
        $method = "AES-256-CBC";
        $options = 0;
        $iv = 'Qkcnaiag24r9cnxZ';

        return openssl_encrypt($name, $method, $key, $options, $iv);
    }

    protected function dekripsi($name, $key){
        
        $method = "AES-256-CBC";
        $options = 0;
        $iv = 'Qkcnaiag24r9cnxZ';

        return openssl_decrypt($name, $method, $key, $options, $iv);
    }
}
