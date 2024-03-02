<?php

namespace Tests\Unit\UseCase\Video;

use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\Domain\ValueObject\Uuid;
use CatalogVideo\UseCase\Video\Delete\DeleteVideoUseCase;
use CatalogVideo\UseCase\Video\Delete\DTO\DeleteInputVideoDTO;
use CatalogVideo\UseCase\Video\Delete\DTO\DeleteOutputVideoDTO;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class DeleteVideoUseCaseUnitTest extends TestCase
{
    public function test_delete()
    {
        $useCase = new DeleteVideoUseCase(
            repository: $this->mockRepository()
        );

        $response = $useCase->exec(
            input: $this->mockInputDTO()
        );

        $this->assertInstanceOf(DeleteOutputVideoDTO::class, $response);

        Mockery::close();
    }

    private function mockRepository()
    {
        $mockRepository = Mockery::mock(stdClass::class, VideoRepositoryInterface::class);
        $mockRepository->shouldReceive('delete')
                        ->once()
                        ->andReturn(true);

        return $mockRepository;
    }

    private function mockInputDTO()
    {
        return Mockery::mock(DeleteInputVideoDTO::class, [
            Uuid::random(),
        ]);
    }
}
