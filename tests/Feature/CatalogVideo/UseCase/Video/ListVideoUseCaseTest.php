<?php namespace Tests\Feature\CatalogVideo\UseCase\Video;

use App\Models\Video;
use CatalogVideo\Domain\Exceptions\NotFoundException;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Video\List\DTO\ListInputVideoUseCase;
use CatalogVideo\UseCase\Video\List\ListVideoUseCase;
use Tests\TestCase;

class ListVideoUseCaseTest extends TestCase
{
    public function test_list()
    {
        $video = Video::factory()->create();

        $useCase = new ListVideoUseCase(
            $this->app->make(VideoRepositoryInterface::class)
        );

        $response = $useCase->exec(new ListInputVideoUseCase(
            id: $video->id
        ));

        $this->assertNotNull($response);
        $this->assertEquals($video->id, $response->id);
    }

    public function test_exception()
    {
        $this->expectException(NotFoundException::class);

        $useCase = new ListVideoUseCase(
            $this->app->make(VideoRepositoryInterface::class)
        );

        $useCase->exec(new ListInputVideoUseCase(
            id: 'fake_id'
        ));
    }
}
