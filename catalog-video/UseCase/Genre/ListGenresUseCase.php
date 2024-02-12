<?php namespace CatalogVideo\UseCase\Genre;

use CatalogVideo\Domain\Repository\GenreRepositoryInterface;
use CatalogVideo\UseCase\DTO\Genre\List\ListGenresInputDto;
use CatalogVideo\UseCase\DTO\Genre\List\ListGenresOutputDto;

class ListGenresUseCase
{
    protected $repository;

    public function __construct(GenreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListGenresInputDto $input): ListGenresOutputDto
    {
        $response = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage,
        );

        return new ListGenresOutputDto(
            items: $response->items(),
            total: $response->total(),
            current_page: $response->currentPage(),
            last_page: $response->lastPage(),
            first_page: $response->firstPage(),
            per_page: $response->perPage(),
            to: $response->to(),
            from: $response->from(),
        );
    }
}
