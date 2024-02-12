<?php namespace CatalogVideo\Domain\Repository;

use CatalogVideo\Domain\Entity\Entity;

interface VideoRepositoryInterface extends EntityRepositoryInterface
{
    public function updateMedia(Entity $entity): Entity;
}
