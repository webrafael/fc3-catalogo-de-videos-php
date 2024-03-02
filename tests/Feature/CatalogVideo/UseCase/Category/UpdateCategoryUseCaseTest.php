<?php namespace Tests\Feature\CatalogVideo\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use CatalogVideo\UseCase\Category\UpdateCategoryUseCase;
use CatalogVideo\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDto;
use Tests\TestCase;

class UpdateCategoryUseCaseTest extends TestCase
{
    public function test_update()
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new UpdateCategoryUseCase($repository);
        $responseUseCase = $useCase->execute(
            new CategoryUpdateInputDto(
                id: $categoryDb->id,
                name: 'name updated',
            )
        );

        $this->assertEquals('name updated', $responseUseCase->name);
        $this->assertEquals($categoryDb->description, $responseUseCase->description);

        $this->assertDatabaseHas('categories', [
            'name' => $responseUseCase->name,
        ]);
    }
}
