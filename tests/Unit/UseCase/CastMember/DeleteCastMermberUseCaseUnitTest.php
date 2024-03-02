<?php

namespace Tests\Unit\UseCase\CastMember;

use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\UseCase\CastMember\DeleteCastMemberUseCase;
use CatalogVideo\UseCase\DTO\CastMember\CastMemberInputDto;
use CatalogVideo\UseCase\DTO\CastMember\Delete\DeleteCastMemberOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use stdClass;

class DeleteCastMermberUseCaseUnitTest extends TestCase
{
    public function test_delete()
    {
        $uuid = (string) RamseyUuid::uuid4();

        $mockRepository = Mockery::mock(stdClass::class, CastMemberRepositoryInterface::class);
        $mockRepository->shouldReceive('delete')
                            ->once()
                            ->andReturn(true);

        $mockInputDto = Mockery::mock(CastMemberInputDto::class, [$uuid]);

        $useCase = new DeleteCastMemberUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(DeleteCastMemberOutputDto::class, $response);

        Mockery::close();
    }
}
