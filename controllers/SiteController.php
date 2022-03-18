<?php

namespace app\controllers;

use app\models\SignupForm;
use app\models\User;
use Workerman\Worker;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\AboutService;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (in_array($action->id, ['contact', 'index', 'about', ])) {
            if (!Yii::$app->user->isGuest) {
                if (!isset($_COOKIE['_identity'])) {
                    Yii::$app->session->setFlash('end_of_session', "Сессия истекла");
                    $this->actionLogout();
                }
            } else {
                if (Yii::$app->request->cookies->get('_identity')) {
                    $identity = str_replace(['[', ']'], '', Yii::$app->request->cookies->get('_identity')->value);
                    $id = explode(',', $identity)[0];
                    $user = User::findIdentity($id);
                    Yii::$app->user->login($user,  3600*24*30);
                } else {
                    $this->redirect('login');
                }
            }
        }
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionOpenSignup() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validate()) {
                Yii::$app->session->setFlash('bad-data', "Длина логина и пароля должна не более 45 символов");
                return $this->redirect('login');
            }
            $checkLogin = $model->checkLogin();
            if ($checkLogin === false) {
                $this->redirect('/error/database');
            }
            if ($checkLogin > 0) {
                Yii::$app->session->setFlash('used', "Пользователь " . $model->username . " уже зарегистрирован");
                return $this->redirect('login');
            }

            if (!$model->register()) {
                $this->redirect('/error/database');
            }
            Yii::$app->session->setFlash('success', "Пользователь " . $model->username . " был успешно зарегистрирован");
            return $this->redirect('login');
        }

        return $this->renderAjax('signup', [
            'model' => $model,
        ]);
    }

    public function actionSignup(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /*$model = new SignupForm();
        return $this->renderAjax('signup', [
            'model' => $model,
        ]);*/
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        return $this->render('contact');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $model = new AboutService();
        $data = $model->showLabs();
        $request['limit'] = 5;
        $request['page'] = 0;
        if (Yii::$app->request->post()) {
            $request = Yii::$app->request->post();
        }
        return $this->render('about', [
            'data' => $data,
            'request' => $request,
        ]);
    }

    public function actionSocket()
    {
        $wsWorker = new Worker('websocket://0.0.0.0:2346');
        $wsWorker->count = 1;


        $wsWorker->onConnect = function($connection) {
            echo 'New connection \n';
        };

        $wsWorker->onMessage = function($connection, $data) use ($wsWorker) {
            foreach ($wsWorker->connections as $clientConnection) {
                $clientConnection->send($data);
            }
        };

        $wsWorker->onClose = function($connection) {
            echo 'Connection close \n';
        };

        Worker::runAll();
    }


}
