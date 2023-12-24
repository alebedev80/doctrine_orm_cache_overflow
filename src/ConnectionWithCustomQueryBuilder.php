<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;

final class ConnectionWithCustomQueryBuilder extends QueryBuilder
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->setFirstResult(0);
        $this->setMaxResults(null);
    }


    /**
     * Sets the position of the first result to retrieve (the "offset").
     *
     * @param int $firstResult The first result to return.
     *
     * @return $this This QueryBuilder instance.
     * @throws InvalidArgumentException
     */
    public function setFirstResult($firstResult): ConnectionWithCustomQueryBuilder
    {
        $firstResult = (int) $firstResult;
        if($firstResult < 0) {
            throw new InvalidArgumentException('The $firstResult parameter should be greater or equal to 0.');
        }


        $this->setParameter(LimitOffsetPlaceholders::OFFSET_PLACEHOLDER, $firstResult, ParameterType::INTEGER);
        parent::setFirstResult($firstResult);

        return $this;
    }

    /**
     * Sets the maximum number of results to retrieve (the "limit").
     *
     * @param int|null $maxResults The maximum number of results to retrieve or NULL to retrieve all results.
     *
     * @return $this This QueryBuilder instance.
     */
    public function setMaxResults($maxResults): ConnectionWithCustomQueryBuilder
    {
        $maxResults = $maxResults !== null ? (int) $maxResults : PHP_INT_MAX;
        parent::setMaxResults($maxResults);
        $this->setParameter(LimitOffsetPlaceholders::LIMIT_PLACEHOLDER, $maxResults, ParameterType::INTEGER);

        return $this;
    }


}