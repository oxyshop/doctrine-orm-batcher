<?php

declare(strict_types=1);

namespace Setono\DoctrineORMBatcher\Batcher\Range;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\DoctrineORMBatcher\Batch\RangeBatch;
use Setono\DoctrineORMBatcher\Batch\RangeBatchInterface;

final class IdRangeBatcher extends RangeBatcher implements IdRangeBatcherInterface
{
    /**
     * @return iterable<RangeBatchInterface>
     *
     * @throws StringsException
     * @throws MappingException
     */
    public function getBatches(int $batchSize = 100): iterable
    {
        $result = $this->getResult(sprintf('%s.%s', $this->alias, $this->identifier), $batchSize);

        foreach ($result as $ids) {
            // because we order the result set by id asc we know that the lowest number is on index 0 and the highest is on the last index
            yield new RangeBatch($ids[0]['id'], $ids[count($ids) - 1]['id'], $this->getBatchableQueryBuilder());
        }
    }
}
