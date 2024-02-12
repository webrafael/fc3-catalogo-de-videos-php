<?php namespace CatalogVideo\Domain\Entity;

use CatalogVideo\Domain\Entity\Traits\SupportEntityTrait;
use CatalogVideo\Domain\Enum\CastMemberType;
use CatalogVideo\Domain\Validation\DomainValidation;
use CatalogVideo\Domain\ValueObject\Uuid;
use DateTime;

class CastMember
{
    use SupportEntityTrait;

    public function __construct(
        protected string $name,
        protected CastMemberType $type,
        protected ?Uuid $id = null,
        protected ?DateTime $createdAt = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->createdAt = $this->createdAt ?? new DateTime();

        $this->validate();
    }

    public function update(string $name)
    {
        $this->name = $name;

        $this->validate();
    }

    protected function validate()
    {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
    }
}
