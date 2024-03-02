<?php

namespace Tests\Unit\UseCase\Genre;

use Mockery;
use stdClass;
use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;
use CatalogVideo\UseCase\Genre\ListGenreUseCase;
use CatalogVideo\UseCase\DTO\Genre\GenreInputDto;
use CatalogVideo\UseCase\DTO\Genre\GenreOutputDto;
use CatalogVideo\Domain\Entity\Genre as EntityGenre;
use CatalogVideo\Domain\Repository\GenreRepositoryInterface;
use CatalogVideo\Domain\ValueObject\Uuid as ValueObjectUuid;

class ListGenreUseCaseUnitTest extends TestCase
{
    public function test_list_single()
    {
        $uuid = (string) Uuid::uuid4();

        $mockEntity = Mockery::mock(EntityGenre::class, [
            'teste', new ValueObjectUuid($uuid), true, [],
        ]);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepository = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')->once()->with($uuid)->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(GenreInputDto::class, [
            $uuid,
        ]);

        $useCase = new ListGenreUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(GenreOutputDto::class, $response);

        Mockery::close();
    }
}
