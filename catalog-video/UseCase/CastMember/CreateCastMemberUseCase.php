<?php namespace CatalogVideo\UseCase\CastMember;

use CatalogVideo\Domain\Entity\CastMember;
use CatalogVideo\Domain\Enum\CastMemberType;
use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\UseCase\DTO\CastMember\Create\CastMemberCreateInputDto;
use CatalogVideo\UseCase\DTO\CastMember\Create\CastMemberCreateOutputDto;

class CreateCastMemberUseCase
{
    protected $repository;

    public function __construct(CastMemberRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CastMemberCreateInputDto $input): CastMemberCreateOutputDto
    {
        $entity = new CastMember(
            name: $input->name,
            type: $input->type == 1 ? CastMemberType::DIRECTOR : CastMemberType::ACTOR
        );

        $this->repository->insert($entity);

        return new CastMemberCreateOutputDto(
            id: $entity->id(),
            name: $entity->name,
            type: $input->type,
            created_at: $entity->createdAt(),
        );
    }
}
