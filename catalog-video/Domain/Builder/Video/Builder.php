<?php namespace CatalogVideo\Domain\Builder\Video;

use CatalogVideo\Domain\Entity\Video as Entity;
use CatalogVideo\Domain\Enum\MediaStatus;

interface Builder
{
    public function createEntity(object $input): Builder;

    public function addMediaVideo(string $path, MediaStatus $mediaStatus, string $encodedPath = ''): Builder;

    public function addTrailer(string $path): Builder;

    public function addThumb(string $path): Builder;

    public function addThumbHalf(string $path): Builder;

    public function addBanner(string $path): Builder;

    public function getEntity(): Entity;
}
