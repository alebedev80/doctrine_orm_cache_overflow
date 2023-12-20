<?php

namespace App;


require_once dirname(__DIR__) . '/vendor/autoload.php';

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;



$c = require dirname(__DIR__) . '/config.php';

$conn = new \PDO("mysql:host={$c['db']['host']};dbname={$c['db']['dbname']}", $c['db']['user'], $c['db']['password']);
$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare('SELECT * FROM users LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', 10, \PDO::PARAM_INT);
$stmt->bindValue(':offset', 0, \PDO::PARAM_INT);
$stmt->execute();

echo "OK\n";
