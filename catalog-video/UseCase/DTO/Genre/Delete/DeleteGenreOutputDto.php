<?php namespace CatalogVideo\UseCase\DTO\Genre\Delete;

class DeleteGenreOutputDto
{
    public function __construct(
        public bool $success
    ) {
    }
}
