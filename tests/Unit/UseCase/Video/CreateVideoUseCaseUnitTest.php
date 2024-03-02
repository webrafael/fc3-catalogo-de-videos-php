<?php

namespace Tests\Unit\UseCase\Video;

use CatalogVideo\Domain\Enum\Rating;
use CatalogVideo\UseCase\Video\Create\CreateVideoUseCase;
use CatalogVideo\UseCase\Video\Create\DTO\CreateInputVideoDTO;
use CatalogVideo\UseCase\Video\Create\DTO\CreateOutputVideoDTO;
use Mockery;

class CreateVideoUseCaseUnitTest extends BaseVideoUseCaseUnitTest
{
    public function test_exec_input_output()
    {
        $this->createUseCase();

        $response = $this->useCase->exec(
            input: $this->createMockInputDTO(),
        );

        $this->assertInstanceOf(CreateOutputVideoDTO::class, $response);
    }

    protected function nameActionRepository(): string
    {
        return 'insert';
    }

    protected function getUseCase(): string
    {
        return CreateVideoUseCase::class;
    }

    protected function createMockInputDTO(
        array $categoriesIds = [],
        array $genresIds = [],
        array $castMembersIds = [],
        ?array $videoFile = null,
        ?array $trailerFile = null,
        ?array $thumbFile = null,
        ?array $thumbHalf = null,
        ?array $bannerFile = null,
    ) {
        return Mockery::mock(CreateInputVideoDTO::class, [
            'title',
            'desc',
            2023,
            12,
            true,
            Rating::RATE10,
            $categoriesIds,
            $genresIds,
            $castMembersIds,
            $videoFile,
            $trailerFile,
            $thumbFile,
            $thumbHalf,
            $bannerFile,
        ]);
    }
}
