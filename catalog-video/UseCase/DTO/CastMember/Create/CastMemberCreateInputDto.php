<?php namespace CatalogVideo\UseCase\DTO\CastMember\Create;

class CastMemberCreateInputDto
{
    public function __construct(
        public string $name,
        public int $type,
    ) {
    }
}
