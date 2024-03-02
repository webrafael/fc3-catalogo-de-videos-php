<?php namespace Tests\Feature\CatalogVideo\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use CatalogVideo\UseCase\Category\ListCategoriesUseCase;
use CatalogVideo\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    public function test_list_empty()
    {
        $responseUseCase = $this->createUseCase();

        $this->assertCount(0, $responseUseCase->items);
    }

    public function test_list_all()
    {
        $categoriesDb = Model::factory()->count(20)->create();

        $responseUseCase = $this->createUseCase();

        $this->assertCount(15, $responseUseCase->items);
        $this->assertEquals(count($categoriesDb), $responseUseCase->total);
    }

    private function createUseCase()
    {
        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new ListCategoriesUseCase($repository);

        return $useCase->execute(new ListCategoriesInputDto());
    }
}
