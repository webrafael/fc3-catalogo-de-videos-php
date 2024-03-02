<?php

namespace Tests\Unit\UseCase\Video;

use CatalogVideo\Domain\Entity\Video as Entity;
use CatalogVideo\Domain\Enum\Rating;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\Domain\ValueObject\Uuid;
use CatalogVideo\UseCase\Video\List\DTO\ListInputVideoUseCase;
use CatalogVideo\UseCase\Video\List\DTO\ListOutputVideoUseCase;
use CatalogVideo\UseCase\Video\List\ListVideoUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListVideoUseCaseUnitTest extends TestCase
{
    public function test_list()
    {
        $uuid = Uuid::random();

        $useCase = new ListVideoUseCase(
            repository: $this->mockRepository()
        );

        $response = $useCase->exec(
            input: $this->mockInputDTO($uuid)
        );

        $this->assertInstanceOf(ListOutputVideoUseCase::class, $response);
    }

    private function mockInputDTO(string $id)
    {
        return Mockery::mock(ListInputVideoUseCase::class, [
            $id,
        ]);
    }

    private function mockRepository()
    {
        $mockRepository = Mockery::mock(stdClass::class, VideoRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
                        ->once()
                        ->andReturn($this->getEntity());

        return $mockRepository;
    }

    private function getEntity(): Entity
    {
        return new Entity(
            title: 'title',
            description: 'desc',
            yearLaunched: 2026,
            duration: 1,
            opened: true,
            rating: Rating::L
        );
    }
}
