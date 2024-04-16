<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Register extends ActiveRecord
{
    public $password;

    public function rules()
    {
        return [
            ['full_name', 'required', 'message' => 'Please provide your full name', 'on' => 'add'],
            ['full_name', 'filter', 'filter' => 'trim', 'on' => 'add'],
            ['full_name', 'filter', 'filter' => function ($value) {
                return str_replace('  ', ' ', $value);
            }, 'skipOnArray' => true, 'on' => 'add'],


            ['email', 'required', 'message' => 'Please provide Your Email', 'on' => 'add'],
            ['email', 'filter', 'filter' => 'trim', 'on' => 'add'],
            ['email', 'email', 'on' => 'add'],
            ['email', 'string', 'max' => 255, 'on' => 'add'],
            ['email', 'unique', 'targetClass' => '\app\models\Register', 'message' => 'This email address has already been taken. Please enter another email.', 'on' => 'add'],

            ['id_no', 'required', 'message' => 'Please provide your ID No.', 'on' => 'add'],
            ['id_no', 'filter', 'filter' => 'trim', 'on' => 'add'],
            ['id_no', 'integer', 'on' => 'add'],
            ['id_no', 'unique', 'targetClass' => '\app\models\Register', 'message' => 'The provided ID No has already been registered Kindly use another one.', 'on' => 'add'],

            ['password', 'required', 'message' => 'Please Enter Your Password', 'on' => 'add'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Password only accepts 3-32 characters letters or numbers.', 'on' => 'add'],
            ['password', 'string', 'min' => 3, 'max' => 32, 'on' => 'add'],


        ];
    }
    public static function tableName()
    {
        return 'user';
    }

    public function registerUser()
    {
        $model = new Register();
        $model->full_name = $this->full_name;
        $model->email = $this->email;
        $model->id_no = $this->id_no;
        $model->password_hash = $this->setPassword();
        if ($model->save()) {
            return true;
        }
        return false;
    }

    //generate password hash
    public function setPassword()
    {
        return Yii::$app->security->generatePasswordHash($this->password);
    }
}
