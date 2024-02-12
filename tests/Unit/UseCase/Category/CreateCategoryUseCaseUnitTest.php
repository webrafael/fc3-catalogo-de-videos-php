<?php namespace Tests\Unit\UseCase\Category;

use CatalogVideo\Domain\Entity\Category;
use CatalogVideo\Domain\Repository\CategoryRepositoryInterface;
use CatalogVideo\UseCase\Category\CreateCategoryUseCase;
use CatalogVideo\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;
use CatalogVideo\UseCase\DTO\Category\CreateCategory\CategoryCreateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    protected $spy;
    protected $mockRepo;
    protected $mockEntity;
    protected $mockInputDto;

    /**
     * IMPORTANTE! Para fins de testes de criação de entidades mocadas, é
     * extremamente importante verificar se todos os métodos públicos
     * serão testados, o que não for exposto ao teste deverá ser método
     * privado para evitar erros de implementação do mock.
     *
     * @return void
     */
    public function testCreateNewCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'name cat';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName,
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($uuid);

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CategoryCreateInputDto::class, [
            $categoryName,
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryCreateOutputDto::class, $responseUseCase);
        $this->assertEquals($categoryName, $responseUseCase->name);
        $this->assertEquals('', $responseUseCase->description);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);
        $useCase = new CreateCategoryUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();
    }
}
