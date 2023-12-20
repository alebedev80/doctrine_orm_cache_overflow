<?php

namespace App;


require_once dirname(__DIR__) . '/vendor/autoload.php';

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;


$c = require dirname(__DIR__) . '/config.php';

$redis = (new RedisCacheBuilder($c))->build();
$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__."/src/entities"],
    false,
    '/tmp/doctrine',
    $redis,
    true
);

$entityManager = EntityManager::create($c['db'], $config);

$query = $entityManager->createQuery('SELECT u FROM App\Entities\User u');
for ($offset = 0; $offset < 100; $offset += 10) {
    $query->setMaxResults(10);
    $query->setFirstResult($offset);
    $query->getResult();
    echo "Iter #$offset \n";
}


$redis = (new RedisCacheBuilder($c))->buildRedis();
$allKeys = $redis->keys('*');

echo "Cache Keys:\n";
foreach ($allKeys as $key) {
    echo $key . "\n";
    $cacheContent = $redis->get($key);
    echo "Content: " . $cacheContent . "\n";
}
