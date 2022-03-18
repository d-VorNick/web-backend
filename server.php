<?php
use Workerman\Worker;

require_once __DIR__ . '/vendor/autoload.php';

$wsWorker = new Worker('websocket://web-2sem.herokuapp.com');
$wsWorker->count = 4;


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