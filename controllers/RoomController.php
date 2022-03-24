<?php


namespace app\controllers;


use app\models\RoomService;
use Yii;
use yii\web\Controller;

class RoomController extends Controller
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionTakePlace() {
        $id = Yii::$app->request->get('id');
        $model = new RoomService();
        if ($id == 1 | $id == 2) {
            $room = 1;
            $model->takePlace($room, $id);
            return $this->asJson(['room' => $room]);
        }
        if ($id == 3 | $id == 4) {
            $room = 2;
            $model->takePlace($room, $id);
            return $this->asJson(['room' => $room]);
        }
        if ($id == 5 | $id == 6) {
            $room = 3;
            $model->takePlace($room, $id);
            return $this->asJson(['room' => $room]);
        }
    }

}