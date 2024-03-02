<?php namespace Tests\Feature\CatalogVideo\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use CatalogVideo\UseCase\Category\DeleteCategoryUseCase;
use CatalogVideo\UseCase\DTO\Category\CategoryInputDto;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase
{
    public function test_delete()
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new DeleteCategoryUseCase($repository);
        $useCase->execute(
            new CategoryInputDto(
                id: $categoryDb->id
            )
        );

        $this->assertSoftDeleted($categoryDb);
    }
}
