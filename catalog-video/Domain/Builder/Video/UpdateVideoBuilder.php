<?php namespace CatalogVideo\Domain\Builder\Video;

use CatalogVideo\Domain\Entity\Video as Entity;
use CatalogVideo\Domain\ValueObject\Uuid;
use DateTime;

class UpdateVideoBuilder extends BuilderVideo
{
    public function createEntity(object $input): Builder
    {
        $this->entity = new Entity(
            id: new Uuid($input->id),
            title: $input->title,
            description: $input->description,
            yearLaunched: $input->yearLaunched,
            duration: $input->duration,
            opened: true,
            rating: $input->rating,
            createdAt: new DateTime($input->createdAt),
        );

        $this->addIds($input);

        return $this;
    }

    public function setEntity(Entity $entity): Builder
    {
        $this->entity = $entity;

        return $this;
    }
}
