<?php namespace Tests\Feature\CatalogVideo\UseCase\Video;

use App\Models\Video;
use CatalogVideo\Domain\Exceptions\NotFoundException;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Video\Delete\DeleteVideoUseCase;
use CatalogVideo\UseCase\Video\Delete\DTO\DeleteInputVideoDTO;
use Tests\TestCase;

class DeleteVideoUseCaseTest extends TestCase
{
    public function test_delete()
    {
        $video = Video::factory()->create();

        $useCase = new DeleteVideoUseCase(
            $this->app->make(VideoRepositoryInterface::class)
        );

        $response = $useCase->exec(new DeleteInputVideoDTO(
            id: $video->id
        ));

        $this->assertTrue($response->deleted);
    }

    public function test_delete_id_not_found()
    {
        $this->expectException(NotFoundException::class);

        $useCase = new DeleteVideoUseCase(
            $this->app->make(VideoRepositoryInterface::class)
        );

        $useCase->exec(new DeleteInputVideoDTO(
            id: 'fake_id'
        ));
    }
}
