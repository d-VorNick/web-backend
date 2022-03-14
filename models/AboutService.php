<?php


namespace app\models;


use Yii;

class AboutService
{
    const  QUERY_TYPE_ALL = 'all';

    public function showLabs()
    {
        $q = 'SELECT name, min, max, week FROM labs';
        $result = Yii::$app->db->createCommand($q)->queryAll();
        return $result;

    }

}