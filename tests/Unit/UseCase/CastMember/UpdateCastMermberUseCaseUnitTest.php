<?php

namespace Tests\Unit\UseCase\CastMember;

use CatalogVideo\Domain\Entity\CastMember as EntityCastMember;
use CatalogVideo\Domain\Enum\CastMemberType;
use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\Domain\ValueObject\Uuid as ValueObjectUuid;
use CatalogVideo\UseCase\CastMember\UpdateCastMemberUseCase;
use CatalogVideo\UseCase\DTO\CastMember\Update\CastMemberUpdateInputDto;
use CatalogVideo\UseCase\DTO\CastMember\Update\CastMemberUpdateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use stdClass;

class UpdateCastMermberUseCaseUnitTest extends TestCase
{
    public function test_update()
    {
        $uuid = (string) RamseyUuid::uuid4();

        $mockEntity = Mockery::mock(EntityCastMember::class, [
            'name',
            CastMemberType::ACTOR,
            new ValueObjectUuid($uuid),
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('update');

        $mockRepository = Mockery::mock(stdClass::class, CastMemberRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
                            ->times(1)
                            ->with($uuid)
                            ->andReturn($mockEntity);
        $mockRepository->shouldReceive('update')
                            ->once()
                            ->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(CastMemberUpdateInputDto::class, [
            $uuid, 'new name',
        ]);

        $useCase = new UpdateCastMemberUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CastMemberUpdateOutputDto::class, $response);

        Mockery::close();
    }
}
