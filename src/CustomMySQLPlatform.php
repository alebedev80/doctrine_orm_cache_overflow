<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Platforms\MySQLPlatform;

final class CustomMySQLPlatform extends MySQLPlatform
{
    protected function doModifyLimitQuery($query, $limit, $offset)
    {
        if ($limit !== null) {
            $query .= sprintf(' LIMIT :%s', LimitOffsetPlaceholders::LIMIT_PLACEHOLDER);

            if ($offset > 0) {
                $query .= sprintf(' OFFSET :%s', LimitOffsetPlaceholders::OFFSET_PLACEHOLDER);
            }
        } elseif ($offset > 0) {
            // 2^64-1 is the maximum of unsigned BIGINT, the biggest limit possible
            $query .= sprintf(' LIMIT 18446744073709551615 OFFSET %d', $offset);
        }

        return $query;
    }
}