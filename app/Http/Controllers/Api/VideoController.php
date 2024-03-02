<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use CatalogVideo\Domain\Enum\Rating;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use CatalogVideo\UseCase\Video\List\ListVideoUseCase;
use CatalogVideo\UseCase\Video\Create\CreateVideoUseCase;
use CatalogVideo\UseCase\Video\Delete\DeleteVideoUseCase;
use CatalogVideo\UseCase\Video\Update\UpdateVideoUseCase;
use CatalogVideo\UseCase\Video\Paginate\ListVideosUseCase;
use CatalogVideo\UseCase\Video\Create\DTO\CreateInputVideoDTO;
use CatalogVideo\UseCase\Video\Delete\DTO\DeleteInputVideoDTO;
use CatalogVideo\UseCase\Video\List\DTO\ListInputVideoUseCase;
use CatalogVideo\UseCase\Video\Update\DTO\UpdateInputVideoDTO;
use CatalogVideo\UseCase\Video\Paginate\DTO\PaginateInputVideoDTO;

class VideoController extends Controller
{
    public function index(Request $request, ListVideosUseCase $useCase)
    {
        $response = $useCase->exec(
            input: new PaginateInputVideoDTO(
                filter: $request->filter ?? '',
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPerPage: (int) $request->get('per_page', 15)
            )
        );

        return (new ApiAdapter($response))
                    ->toJson();
    }

    public function show(ListVideoUseCase $useCase, $id)
    {
        $response = $useCase->exec(new ListInputVideoUseCase($id));

        return ApiAdapter::json($response);
    }

    public function store(CreateVideoUseCase $useCase, StoreVideoRequest $request)
    {
        $response = $useCase->exec(new CreateInputVideoDTO(
            title: $request->title,
            description: $request->description,
            yearLaunched: $request->year_launched,
            duration: $request->duration,
            opened: $request->opened,
            rating: Rating::from($request->rating),
            categories: $request->categories,
            genres: $request->genres,
            castMembers: $request->cast_members,
            videoFile: getArrayFile($request->file('video_file')),
            trailerFile: getArrayFile($request->file('trailer_file')),
            bannerFile: getArrayFile($request->file('banner_file')),
            thumbFile: getArrayFile($request->file('thumb_file')),
            thumbHalf: getArrayFile($request->file('thumb_half_file')),
        ));

        return ApiAdapter::json($response, Response::HTTP_CREATED);
    }

    public function update(UpdateVideoUseCase $useCase, UpdateVideoRequest $request, $id)
    {
        $response = $useCase->exec(new UpdateInputVideoDTO(
            id: $id,
            title: $request->title,
            description: $request->description,
            categories: $request->categories,
            genres: $request->genres,
            castMembers: $request->cast_members,
            videoFile: getArrayFile($request->file('video_file')),
            trailerFile: getArrayFile($request->file('trailer_file')),
            bannerFile: getArrayFile($request->file('banner_file')),
            thumbFile: getArrayFile($request->file('thumb_file')),
            thumbHalf: getArrayFile($request->file('thumb_half_file')),
        ));

        return ApiAdapter::json($response);
    }

    public function destroy(DeleteVideoUseCase $useCase, $id)
    {
        $useCase->exec(new DeleteInputVideoDTO(id: $id));

        return response()->noContent();
    }
}
