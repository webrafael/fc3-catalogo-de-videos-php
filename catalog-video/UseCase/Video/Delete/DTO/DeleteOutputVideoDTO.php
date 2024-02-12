<?php namespace CatalogVideo\UseCase\Video\Delete\DTO;

class DeleteOutputVideoDTO
{
    public function __construct(
        public bool $deleted
    ) {
    }
}
