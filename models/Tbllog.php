<?php

namespace app\models;

use Yii;

class Tbllog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbllog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['login', 'logout'], 'safe'],
            [['id'], 'string', 'max' => 100],
        ];
    }
}
