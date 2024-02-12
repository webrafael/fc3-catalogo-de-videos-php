<?php namespace CatalogVideo\Domain\Entity\Traits;

use CatalogVideo\Domain\Exceptions\InvalidPropertyEntityException;

trait SupportEntityTrait
{
    public function __get($property)
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        $class = get_class($this);
        throw new InvalidPropertyEntityException("Property {$property} not found in class {$class}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}