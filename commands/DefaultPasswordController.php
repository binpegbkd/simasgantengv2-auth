<?php

namespace app\commands;

use Yii;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Json;
use app\models\User;

class DefaultPasswordController extends Controller
{    
    public function actionIndex(){ 
        
        $user = User::find()->where(['<>', 'nipBaru', '198306292010011024'])->all();
        $no = 0;
        foreach($user as $u){
            $id = $u['id'];
            $nip = $u['nipBaru'];
            User::ubahPassword($id, 'Sapicadel0');
            $u['flag'] = 1;
            $u->save(false);
            $no = $no + 1;
            echo "$no. $nip \n";
        }
        
        echo "\n";
    }
}