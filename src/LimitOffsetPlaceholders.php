<?php

namespace App;

// TODO: convert to Enum
interface LimitOffsetPlaceholders
{
    const MAX_MYSQL_LIMIT = 18446744073709551615;
    public const LIMIT_PLACEHOLDER = '__doctrine_limit_placeholder__';
    public const OFFSET_PLACEHOLDER = '__doctrine_offset_placeholder__';
}