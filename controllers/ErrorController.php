<?php


namespace app\controllers;


use yii\web\Controller;

class ErrorController extends Controller
{
    public function actionNotReg()
    {
        $this->layout = false;
        return $this->render('401', ['message' => 'Пользователь не зарегистрирован в системе']);
    }

    public function actionAuthError()
    {
        $this->layout = false;
        return $this->render('403', ['message' => 'Ошибка авторизации']);
    }

    public function actionDatabase()
    {
        $this->layout = false;
        return $this->render('database', ['message' => 'Ошибка при обращении к базе данных']);
    }

}
