<?php namespace Tests\Feature\CatalogVideo\UseCase\Genre;

use App\Models\Genre as Model;
use App\Repositories\Eloquent\GenreEloquentRepository;
use CatalogVideo\UseCase\DTO\Genre\GenreInputDto;
use CatalogVideo\UseCase\Genre\ListGenreUseCase;
use Tests\TestCase;

class ListGenreUseCaseTest extends TestCase
{
    public function testFindById()
    {
        $useCase = new ListGenreUseCase(
            new GenreEloquentRepository(new Model())
        );

        $genre = Model::factory()->create();

        $responseUseCase = $useCase->execute(new GenreInputDto(
            id: $genre->id
        ));

        $this->assertEquals($genre->id, $responseUseCase->id);
        $this->assertEquals($genre->name, $responseUseCase->name);
    }
}
