<?php

namespace Tests\Unit\UseCase\Video;

use CatalogVideo\Domain\Repository\PaginationInterface;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Video\Paginate\DTO\{
    PaginateInputVideoDTO
};
use CatalogVideo\UseCase\Video\Paginate\ListVideosUseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Unit\UseCase\UseCaseTrait;
use stdClass;

class ListVideosUseCaseUnitTest extends TestCase
{
    use UseCaseTrait;

    public function test_list_paginate()
    {
        $useCase = new ListVideosUseCase(
            repository: $this->mockRepository()
        );

        $response = $useCase->exec(
            input: $this->mockInputDTO()
        );

        $this->assertInstanceOf(PaginationInterface::class, $response);

        Mockery::close();
    }

    private function mockRepository()
    {
        $mockRepository = Mockery::mock(stdClass::class, VideoRepositoryInterface::class);
        $mockRepository->shouldReceive('paginate')
                        ->once()
                        ->andReturn($this->mockPagination());

        return $mockRepository;
    }

    private function mockInputDTO()
    {
        return Mockery::mock(PaginateInputVideoDTO::class, [
            '',
            'DESC',
            1,
            15,
        ]);
    }
}
