<?php

declare(strict_types=1);

namespace Setono\DoctrineORMBatcher\Batcher\Range;

use Doctrine\ORM\QueryBuilder;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\DoctrineORMBatcher\Batch\RangeBatch;
use Setono\DoctrineORMBatcher\Batcher\Batcher;

abstract class RangeBatcher extends Batcher implements RangeBatcherInterface
{
    /**
     * @throws StringsException
     */
    protected function getBatchableQueryBuilder(): QueryBuilder
    {
        $qb = $this->getQueryBuilder();
        $qb->andWhere(sprintf('%s.%s >= :%s', $this->alias, $this->identifier, RangeBatch::PARAMETER_LOWER_BOUND));
        $qb->andWhere(sprintf('%s.%s <= :%s', $this->alias, $this->identifier, RangeBatch::PARAMETER_UPPER_BOUND));

        return $qb;
    }
}
