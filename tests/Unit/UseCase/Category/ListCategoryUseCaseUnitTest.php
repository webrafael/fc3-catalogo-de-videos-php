<?php namespace Tests\Unit\UseCase\Category;

use CatalogVideo\Domain\Entity\Category as CategoryEntity;
use CatalogVideo\Domain\Repository\CategoryRepositoryInterface;
use CatalogVideo\UseCase\Category\ListCategoryUseCase;
use CatalogVideo\UseCase\DTO\Category\CategoryInputDto;
use CatalogVideo\UseCase\DTO\Category\CategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoryUseCaseUnitTest extends TestCase
{
    protected $spy;
    protected $mockRepo;
    protected $mockEntity;
    protected $mockInputDto;

    public function testGetById()
    {
        $id = (string) Uuid::uuid4()->toString();

        $this->mockEntity = Mockery::mock(CategoryEntity::class, [
            $id,
            'teste category',
        ]);
        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepo->shouldReceive('findById')
                        ->with($id)
                        ->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(CategoryInputDto::class, [
            $id,
        ]);

        $useCase = new ListCategoryUseCase($this->mockRepo);
        $response = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryOutputDto::class, $response);
        $this->assertEquals('teste category', $response->name);
        $this->assertEquals($id, $response->id);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);
        $useCase = new ListCategoryUseCase($this->spy);
        $response = $useCase->execute($this->mockInputDto);
        $this->spy->shouldHaveReceived('findById');
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
