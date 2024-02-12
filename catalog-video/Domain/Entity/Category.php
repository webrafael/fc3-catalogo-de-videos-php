<?php namespace CatalogVideo\Domain\Entity;

use DateTime;
use CatalogVideo\Domain\ValueObject\Uuid;
use CatalogVideo\Domain\Validation\DomainValidation;
use CatalogVideo\Domain\Entity\Traits\SupportEntityTrait;


class Category
{
    use SupportEntityTrait;

    public function __construct(
        protected Uuid|string $id = '',
        protected string $name = '',
        protected ?string $description = '',
        protected ?bool $isActive = true,
        protected DateTime|string $createdAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    public function update(string $name, ?string $description = ''): void
    {
        $this->name = $name;
        $this->description = $description;

        $this->validate();
    }

    private function validate()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
        DomainValidation::strCanNullAndMaxLength($this->description);
    }
}