<?php namespace Tests\Feature\CatalogVideo\UseCase\Genre;

use App\Models\Genre as Model;
use App\Repositories\Eloquent\GenreEloquentRepository;
use CatalogVideo\UseCase\DTO\Genre\GenreInputDto;
use CatalogVideo\UseCase\Genre\DeleteGenreUseCase;
use Tests\TestCase;

class DeleteGenreUseCaseTest extends TestCase
{
    public function testDelete()
    {
        $useCase = new DeleteGenreUseCase(
            new GenreEloquentRepository(new Model())
        );

        $genre = Model::factory()->create();

        $responseUseCase = $useCase->execute(new GenreInputDto(
            id: $genre->id
        ));

        $this->assertTrue($responseUseCase->success);

        $this->assertSoftDeleted('genres', [
            'id' => $genre->id,
        ]);
    }
}
