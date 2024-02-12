<?php namespace CatalogVideo\UseCase\CastMember;

use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\UseCase\DTO\CastMember\CastMemberInputDto;
use CatalogVideo\UseCase\DTO\CastMember\CastMemberOutputDto;

class ListCastMemberUseCase
{
    protected $repository;

    public function __construct(CastMemberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CastMemberInputDto $input): CastMemberOutputDto
    {
        $castMember = $this->repository->findById($input->id);

        return new CastMemberOutputDto(
            id: $castMember->id(),
            name: $castMember->name,
            type: $castMember->type->value,
            created_at: $castMember->createdAt(),
        );
    }
}
