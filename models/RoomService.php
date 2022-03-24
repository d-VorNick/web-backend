<?php


namespace app\models;


use Yii;

class RoomService
{
    const  QUERY_TYPE_ALL = 'all';

    public function takePlace($room, $id)
    {
        if ($id % 2 == 0) {
            $id = 'second_place';
        } else {
            $id = 'first_place';
        }
        $q = "UPDATE rooms SET {$id} = 0 WHERE id = '{$room}';";
        $result = Yii::$app->db->createCommand($q)->execute();
    }

    public function getData()
    {
        $q = "SELECT * FROM rooms;";
        $result = Yii::$app->db->createCommand($q)->queryAll();
        return $result;
    }

}