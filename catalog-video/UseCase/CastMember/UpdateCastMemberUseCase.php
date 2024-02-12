<?php namespace CatalogVideo\UseCase\CastMember;

use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\UseCase\DTO\CastMember\Update\CastMemberUpdateInputDto;
use CatalogVideo\UseCase\DTO\CastMember\Update\CastMemberUpdateOutputDto;

class UpdateCastMemberUseCase
{
    protected $repository;

    public function __construct(CastMemberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CastMemberUpdateInputDto $input): CastMemberUpdateOutputDto
    {
        $entity = $this->repository->findById($input->id);
        $entity->update(name: $input->name);

        $this->repository->update($entity);

        return new CastMemberUpdateOutputDto(
            id: $entity->id(),
            name: $entity->name,
            type: $entity->type->value,
            created_at: $entity->createdAt(),
        );
    }
}
