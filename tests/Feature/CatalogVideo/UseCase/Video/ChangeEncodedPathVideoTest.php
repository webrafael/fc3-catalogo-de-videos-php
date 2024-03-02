<?php namespace Tests\Feature\CatalogVideo\UseCase\Video;

use App\Models\Video as Model;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Video\ChangeEncoded\ChangeEncodedPathVideo;
use CatalogVideo\UseCase\Video\ChangeEncoded\DTO\ChangeEncodedVideoDTO;
use Tests\TestCase;

class ChangeEncodedPathVideoTest extends TestCase
{
    public function testIfUpdatedMediaInDatabase()
    {
        $video = Model::factory()->create();

        $useCase = new ChangeEncodedPathVideo(
            $this->app->make(VideoRepositoryInterface::class)
        );

        $input = new ChangeEncodedVideoDTO(
            id: $video->id,
            encodedPath: 'path-id/video_encoded.ext',
        );

        $useCase->exec($input);

        $this->assertDatabaseHas('medias_video', [
            'video_id' => $input->id,
            'encoded_path' => $input->encodedPath,
        ]);
    }
}
