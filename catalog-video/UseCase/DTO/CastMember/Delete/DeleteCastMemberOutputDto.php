<?php namespace CatalogVideo\UseCase\DTO\CastMember\Delete;

class DeleteCastMemberOutputDto
{
    public function __construct(
        public bool $success
    ) {
    }
}
