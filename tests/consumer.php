<?php

require_once __DIR__ . '/bootstrap.php';

/** @var \PhpAmqpLib\Connection\AMQPSwooleConnection $conn */
$conn = (new \Swoftx\Amqplib\Connection())->build()->getConnection();

$conn->channel();

go(function () {
    \co::sleep(1000);
});
