<?php namespace CatalogVideo\Domain\Validation;

use CatalogVideo\Domain\Entity\Entity;

interface ValidatorInterface
{
    public function validate(Entity $entity): void;
}
