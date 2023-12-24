<?php

namespace App;


require_once dirname(__DIR__) . '/vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;


$c = require dirname(__DIR__) . '/config.php';

$redis = (new RedisCacheBuilder($c))->build();
$redisNative = (new RedisCacheBuilder($c))->buildRedis();
$redisNative->flushAll();

$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__.'/src/entities'],
    false,
    '/tmp/doctrine',
    $redis,
    true
);

$dbConfig = array_merge($c['db'], [
    'platform' => new CustomMySQLPlatform(),
    'wrapperClass' => CustomConnection::class,
]);

$conn = DriverManager::getConnection($dbConfig, $config);
$entityManager = new EntityManager($conn, $config);



$qb = $conn->createQueryBuilder();
$query = $qb->select('*')->from('users');
//$query = $entityManager->createQuery('SELECT u FROM App\Entities\User u');
$entityManager->createQueryBuilder();
for ($offset = 0; $offset < 100; $offset += 10) {
    $query->setMaxResults(10);
    $query->setFirstResult($offset);
    $query->executeQuery();
    echo "Iter #$offset {$query->getSQL()}\n";
}



$allKeys = $redisNative->keys('*');

echo "Cache Keys:\n";
foreach ($allKeys as $key) {
    echo $key . "\n";
    $cacheContent = $redisNative->get($key);
    echo "Content: " . $cacheContent . "\n";
}
