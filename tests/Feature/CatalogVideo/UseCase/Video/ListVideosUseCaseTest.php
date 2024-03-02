<?php namespace Tests\Feature\CatalogVideo\UseCase\Video;

use App\Models\Video;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Video\Paginate\DTO\PaginateInputVideoDTO;
use CatalogVideo\UseCase\Video\Paginate\ListVideosUseCase;
use Tests\TestCase;

class ListVideosUseCaseTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function test_pagination(
        int $total,
        int $perPage,
    ) {
        Video::factory()->count($total)->create();

        $useCase = new ListVideosUseCase(
            $this->app->make(VideoRepositoryInterface::class)
        );

        $response = $useCase->exec(new PaginateInputVideoDTO(
            filter: '',
            order: 'desc',
            page: 1,
            totalPerPage: $perPage
        ));

        $this->assertCount($perPage, $response->items());
        $this->assertEquals($total, $response->total());
    }

    protected function provider(): array
    {
        return [
            [
                'total' => 30,
                'perPage' => 10,
            ], [
                'total' => 20,
                'perPage' => 5,
            ], [
                'total' => 0,
                'perPage' => 0,
            ],
        ];
    }
}
