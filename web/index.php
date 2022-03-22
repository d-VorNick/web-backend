<?php

use Workerman\Worker;

//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();

/*$socketObject = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$bindToIP = socket_bind($socketObject, '127.0.0.1', '2345');
if (!$bindToIP) {
    die(socket_strerror());
}
$listen = socket_listen($socketObject);
while (True) {
$connectionSuccess = socket_accept($socketObject);
if ($connectionSuccess == false) {

} else {
    echo socket_strerror();
}
}











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

Worker::runAll();*/