<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;

final class CustomConnection extends Connection
{
    public function createQueryBuilder(): ConnectionWithCustomQueryBuilder
    {
        return new ConnectionWithCustomQueryBuilder($this);
    }

}