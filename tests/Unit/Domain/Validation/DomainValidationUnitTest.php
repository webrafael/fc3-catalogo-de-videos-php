<?php namespace Tests\Unit\Domain\Validation;

use Throwable;
use PHPUnit\Framework\TestCase;
use CatalogVideo\Domain\Validation\DomainValidation;
use CatalogVideo\Domain\Exceptions\EntityValidationException;

class DomainValidationUnitTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }
    
    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'Não pode ser vazio');
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Não pode ser vazio');
        }
    }
    
    public function testStrMaxLength()
    {
        try {
            $value = 'sdjklç fdsjkaf çdjsaklgç dsafjkdslaç gsa';
            DomainValidation::strMaxLength($value, 5, 'Custom Message');
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom Message');
        }
    }
    
    public function testStrMinLength()
    {
        try {
            $value = 's';
            DomainValidation::strMinLength($value, 3, 'Custom Message');
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom Message');
        }
    }
    
    public function testStrCanNullAndMaxLength()
    {
        try {
            $value = 'jfsdklgçfdsgfdslç';
            DomainValidation::strCanNullAndMaxLength($value, 8, 'Custom Message');
            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom Message');
        }
    }
}