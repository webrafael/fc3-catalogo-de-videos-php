<?php

namespace Tests\Unit\UseCase\CastMember;

use CatalogVideo\Domain\Entity\CastMember as EntityCastMember;
use CatalogVideo\Domain\Enum\CastMemberType;
use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\Domain\ValueObject\Uuid;
use CatalogVideo\UseCase\CastMember\ListCastMemberUseCase;
use CatalogVideo\UseCase\DTO\CastMember\CastMemberInputDto;
use CatalogVideo\UseCase\DTO\CastMember\CastMemberOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use stdClass;

class ListCastMermberUseCaseUnitTest extends TestCase
{
    public function test_list()
    {
        $uuid = (string) RamseyUuid::uuid4();

        // arrange
        $mockEntity = Mockery::mock(EntityCastMember::class, [
            'name',
            CastMemberType::ACTOR,
            new Uuid($uuid),
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepository = Mockery::mock(stdClass::class, CastMemberRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
                            ->times(1)
                            ->with($uuid)
                            ->andReturn($mockEntity);

        $mockInputDTO = Mockery::mock(CastMemberInputDto::class, [$uuid]);

        $useCase = new ListCastMemberUseCase($mockRepository);
        $response = $useCase->execute($mockInputDTO);

        $this->assertInstanceOf(CastMemberOutputDto::class, $response);

        Mockery::close();
    }
}
