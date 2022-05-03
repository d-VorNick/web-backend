<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{

    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Заполните поле'],
            [['username', 'password'], 'string', 'max' => 45, 'message' => 'Длина логина и пароля не должна превышать 45 символов' ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function register() {
        $pass = md5($this->password);
        $q = "INSERT into users(username, password) 
              VALUES ('{$this->username}', '{$pass}');";
        try {
            Yii::$app->db->createCommand($q)->execute();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkLogin() {
        $q = "SELECT username FROM users WHERE username='{$this->username}';";
        try {
            return Yii::$app->db->createCommand($q)->execute();
        } catch (\Exception $e) {
            return false;
        }

    }
}
