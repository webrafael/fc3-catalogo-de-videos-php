<?php namespace Tests\Feature\CatalogVideo\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use CatalogVideo\UseCase\Category\ListCategoryUseCase;
use CatalogVideo\UseCase\DTO\Category\CategoryInputDto;
use Tests\TestCase;

class ListCategoryUseCaseTest extends TestCase
{
    public function test_list()
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new ListCategoryUseCase($repository);
        $responseUseCase = $useCase->execute(
            new CategoryInputDto(id: $categoryDb->id)
        );

        $this->assertEquals($categoryDb->id, $responseUseCase->id);
        $this->assertEquals($categoryDb->name, $responseUseCase->name);
        $this->assertEquals($categoryDb->description, $responseUseCase->description);
    }
}
