<?php

namespace Tests\Unit\UseCase;

use CatalogVideo\Domain\Entity\CastMember as EntityCastMember;
use CatalogVideo\Domain\Enum\CastMemberType;
use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\UseCase\CastMember\CreateCastMemberUseCase;
use CatalogVideo\UseCase\DTO\CastMember\Create\CastMemberCreateInputDto;
use CatalogVideo\UseCase\DTO\CastMember\Create\CastMemberCreateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateCastMemberUseCaseUnitTest extends TestCase
{
    public function test_create()
    {
        // arrange
        $mockEntity = Mockery::mock(EntityCastMember::class, ['name', CastMemberType::ACTOR]);
        $mockEntity->shouldReceive('id');
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepository = Mockery::mock(stdClass::class, CastMemberRepositoryInterface::class);
        $mockRepository->shouldReceive('insert')
                            ->once()
                            ->andReturn($mockEntity);
        $useCase = new CreateCastMemberUseCase($mockRepository);

        $mockDto = Mockery::mock(CastMemberCreateInputDto::class, [
            'name', 1,
        ]);

        // action
        $response = $useCase->execute($mockDto);

        // assert
        $this->assertInstanceOf(CastMemberCreateOutputDto::class, $response);
        $this->assertNotEmpty($response->id);
        $this->assertEquals('name', $response->name);
        $this->assertEquals(1, $response->type);
        $this->assertNotEmpty($response->created_at);

        Mockery::close();
    }
}
