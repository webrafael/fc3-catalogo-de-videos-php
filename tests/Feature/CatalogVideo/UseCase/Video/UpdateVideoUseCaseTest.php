<?php namespace Tests\Feature\CatalogVideo\UseCase\Video;

use App\Models\Video;
use CatalogVideo\UseCase\Video\Update\DTO\UpdateInputVideoDTO;
use CatalogVideo\UseCase\Video\Update\UpdateVideoUseCase;

class UpdateVideoUseCaseTest extends BaseVideoUseCase
{
    public function useCase(): string
    {
        return UpdateVideoUseCase::class;
    }

    public function inputDTO(
        array $categories = [],
        array $genres = [],
        array $castMembers = [],
        ?array $videoFile = null,
        ?array $trailerFile = null,
        ?array $bannerFile = null,
        ?array $thumbFile = null,
        ?array $thumbHalf = null,
    ): object {
        $video = Video::factory()->create();

        return new UpdateInputVideoDTO(
            id: $video->id,
            title: 'test',
            description: 'test',
            categories: $categories,
            genres: $genres,
            castMembers: $castMembers,
            videoFile: $videoFile,
            trailerFile: $trailerFile,
            bannerFile: $bannerFile,
            thumbFile: $thumbFile,
            thumbHalf: $thumbHalf,
        );
    }
}
