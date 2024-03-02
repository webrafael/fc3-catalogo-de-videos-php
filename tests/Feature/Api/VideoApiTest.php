<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Genre;
use App\Models\Video;
use App\Models\Category;
use App\Models\CastMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Traits\WithoutMiddlewareTrait;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use WithoutMiddlewareTrait;

    protected $endpoint = '/api/videos';

    protected $serializedFields = [
        'id',
        'title',
        'description',
        'year_launched',
        'opened',
        'rating',
        'duration',
        'created_at',
    ];

    /**
     * @test
     */
    public function empty()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertOk();
    }

    /**
     * @test
     * @dataProvider dataProviderPagination
     */
    public function pagination(
        int $total,
        int $totalCurrentPage,
        int $page = 1,
        int $perPage = 15,
        string $filter = '',
    ) {
        Video::factory()->count($total)->create();

        if ($filter) {
            Video::factory()->count($total)->create([
                'title' => $filter,
            ]);
        }

        $params = http_build_query([
            'page' => $page,
            'per_page' => $perPage,
            'order' => 'DESC',
            'filter' => $filter,
        ]);

        $response = $this->getJson("$this->endpoint?$params");

        $response->assertOk();
        $response->assertJsonCount($totalCurrentPage, 'data');
        $response->assertJsonPath('meta.current_page', $page);
        $response->assertJsonPath('meta.per_page', $perPage);
        $response->assertJsonStructure([
            'data' => [
                '*' => $this->serializedFields,
            ],
            'meta' => [
                'total',
                'current_page',
                'last_page',
                'first_page',
                'per_page',
                'to',
                'from',
            ],
        ]);
    }

    protected function dataProviderPagination(): array
    {
        return [
            'test empty' => [
                'total' => 0,
                'totalCurrentPage' => 0,
                'page' => 1,
                'perPage' => 15,
            ],
            'test with total two pages' => [
                'total' => 20,
                'totalCurrentPage' => 15,
                'page' => 1,
                'perPage' => 15,
            ],
            'test page two' => [
                'total' => 20,
                'totalCurrentPage' => 5,
                'page' => 2,
                'perPage' => 15,
            ],
            'test page four' => [
                'total' => 40,
                'totalCurrentPage' => 10,
                'page' => 4,
                'perPage' => 10,
            ],
            'test with filter' => [
                'total' => 10,
                'totalCurrentPage' => 10,
                'page' => 1,
                'perPage' => 10,
                'filter' => 'test',
            ],
        ];
    }

    /**
     * @test
     */
    public function show()
    {
        $video = Video::factory()->create();

        $response = $this->getJson("$this->endpoint/{$video->id}");
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->serializedFields,
        ]);
    }

    /**
     * @test
     */
    public function showNotFound()
    {
        $response = $this->getJson("$this->endpoint/fake_id");
        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function store()
    {
        $mediaVideoFile = UploadedFile::fake()->create('video.mp4', 1, 'video/mp4');
        $imageVideoFile = UploadedFile::fake()->image('image.png');

        $categoriesIds = Category::factory()->count(3)->create()->pluck('id')->toArray();
        $genresIds = Genre::factory()->count(3)->create()->pluck('id')->toArray();
        $castMembersIds = CastMember::factory()->count(3)->create()->pluck('id')->toArray();

        $data = [
            'title' => 'test title',
            'description' => 'test desc',
            'year_launched' => 2000,
            'duration' => 1,
            'rating' => 'L',
            'opened' => true,
            'categories' => $categoriesIds,
            'genres' => $genresIds,
            'cast_members' => $castMembersIds,
            // 'video_file' => $mediaVideoFile,
            'trailer_file' => $mediaVideoFile,
            'banner_file' => $imageVideoFile,
            'thumb_file' => $imageVideoFile,
            'thumb_half_file' => $imageVideoFile,
        ];
        $response = $this->postJson($this->endpoint, $data);
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => $this->serializedFields,
        ]);

        // $this->assertDatabaseCount('videos', 1);
        $this->assertDatabaseHas('videos', [
            'id' => $response->json('data.id'),
        ]);

        $this->assertEquals($categoriesIds, $response->json('data.categories'));
        $this->assertEquals($genresIds, $response->json('data.genres'));
        $this->assertEquals($castMembersIds, $response->json('data.cast_members'));

        // Storage::assertExists($response->json('data.video'));
        Storage::assertExists($response->json('data.trailer'));
        Storage::assertExists($response->json('data.banner'));
        Storage::assertExists($response->json('data.thumb'));
        Storage::assertExists($response->json('data.thumb_half'));

        Storage::deleteDirectory($response->json('data.id'));
    }

    /**
     * @test
     */
    public function update()
    {
        $video = Video::factory()->create();

        $mediaVideoFile = UploadedFile::fake()->create('video.mp4', 1, 'video/mp4');
        $imageVideoFile = UploadedFile::fake()->image('image.png');

        $categoriesIds = Category::factory()->count(3)->create()->pluck('id')->toArray();
        $genresIds = Genre::factory()->count(3)->create()->pluck('id')->toArray();
        $castMembersIds = CastMember::factory()->count(3)->create()->pluck('id')->toArray();

        $data = [
            'title' => 'title updated',
            'description' => 'desc updated',
            'categories' => $categoriesIds,
            'genres' => $genresIds,
            'cast_members' => $castMembersIds,
            // 'video_file' => $mediaVideoFile,
            'trailer_file' => $mediaVideoFile,
            'banner_file' => $imageVideoFile,
            'thumb_file' => $imageVideoFile,
            'thumb_half_file' => $imageVideoFile,
        ];
        $response = $this->putJson("$this->endpoint/{$video->id}", $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => $this->serializedFields,
        ]);

        $this->assertDatabaseCount('videos', 1);
        $this->assertDatabaseHas('videos', [
            'id' => $response->json('data.id'),
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        $this->assertEquals($categoriesIds, $response->json('data.categories'));
        $this->assertEquals($genresIds, $response->json('data.genres'));
        $this->assertEquals($castMembersIds, $response->json('data.cast_members'));

        // Storage::assertExists($response->json('data.video'));
        Storage::assertExists($response->json('data.trailer'));
        Storage::assertExists($response->json('data.banner'));
        Storage::assertExists($response->json('data.thumb'));
        Storage::assertExists($response->json('data.thumb_half'));

        Storage::deleteDirectory($response->json('data.id'));
    }

    /**
     * @test
     */
    // #[Test]
    public function storeValidation()
    {
        $response = $this->postJson($this->endpoint, []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'title',
            'description',
            'year_launched',
            'duration',
            'rating',
            'opened',
            'categories',
            'genres',
            'cast_members',
        ]);
    }

    /**
     * @test
     */
    public function destroy()
    {
        $video = Video::factory()->create();

        $response = $this->deleteJson("$this->endpoint/{$video->id}");
        $response->assertNoContent();

        $this->assertSoftDeleted('videos', [
            'id' => $video->id,
        ]);
    }

    /**
     * @test
     */
    public function destroyNotFound()
    {
        $response = $this->deleteJson("$this->endpoint/fake_id");
        $response->assertNotFound();
    }
}
