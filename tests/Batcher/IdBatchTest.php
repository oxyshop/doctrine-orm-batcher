<?php

namespace Tests\Setono\DoctrineORMBatcher;

use Doctrine\Common\Persistence\ManagerRegistry;
use Setono\DoctrineORMBatcher\Batcher\IdBatcher;

final class IdBatchTest extends EntityManagerAwareTestCase
{
    /**
     * @test
     */
    public function it_works(): void
    {
        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $managerRegistry->method('getManagerForClass')->willReturn($this->entityManager);
        $idBatch = new IdBatcher($managerRegistry, ValidEntity::class);

        $expected = [
            [11, 110],
            [111, 210],
            [211, 310],
            [311, 410],
            [411, 510],
        ];

        $batches = iterator_to_array($idBatch->getBatches());

        $this->assertSame($expected, $batches);
    }
}
