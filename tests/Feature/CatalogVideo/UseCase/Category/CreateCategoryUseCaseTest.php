<?php namespace Tests\Feature\CatalogVideo\UseCase\Category;

use App\Models\Category as Model;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use CatalogVideo\UseCase\Category\CreateCategoryUseCase;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use CatalogVideo\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;

class CreateCategoryUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create()
    {
        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new CreateCategoryUseCase($repository);
        $responseUseCase = $useCase->execute(
            new CategoryCreateInputDto(
                name: 'Teste',
            )
        );

        $this->assertEquals('Teste', $responseUseCase->name);
        $this->assertNotEmpty($responseUseCase->id);

        $this->assertDatabaseHas('categories', [
            'id' => $responseUseCase->id,
        ]);
    }
}
