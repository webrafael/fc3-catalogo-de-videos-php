<?php namespace CatalogVideo\UseCase\CastMember;

use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\UseCase\DTO\CastMember\CastMemberInputDto;
use CatalogVideo\UseCase\DTO\CastMember\Delete\DeleteCastMemberOutputDto;

class DeleteCastMemberUseCase
{
    protected $repository;

    public function __construct(CastMemberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CastMemberInputDto $input): DeleteCastMemberOutputDto
    {
        $hasDeleted = $this->repository->delete($input->id);

        return new DeleteCastMemberOutputDto(
            success: $hasDeleted
        );
    }
}
