<?php namespace CatalogVideo\UseCase\DTO\CastMember\Update;

class CastMemberUpdateInputDto
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
