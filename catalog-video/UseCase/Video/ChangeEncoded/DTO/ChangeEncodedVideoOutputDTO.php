<?php namespace CatalogVideo\UseCase\Video\ChangeEncoded\DTO;

class ChangeEncodedVideoOutputDTO
{
    public function __construct(
        public string $id,
        public string $encodedPath,
    ) {
    }
}
