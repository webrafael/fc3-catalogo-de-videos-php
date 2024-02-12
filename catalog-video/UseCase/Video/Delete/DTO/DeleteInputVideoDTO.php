<?php namespace CatalogVideo\UseCase\Video\Delete\DTO;

class DeleteInputVideoDTO
{
    public function __construct(
        public string $id
    ) {
    }
}
