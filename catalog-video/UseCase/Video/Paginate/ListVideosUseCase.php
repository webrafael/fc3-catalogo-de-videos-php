<?php namespace CatalogVideo\UseCase\Video\Paginate;

use CatalogVideo\Domain\Repository\PaginationInterface;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Video\Paginate\DTO\PaginateInputVideoDTO;

class ListVideosUseCase
{
    public function __construct(
        private VideoRepositoryInterface $repository
    ) {
    }

    public function exec(PaginateInputVideoDTO $input): PaginationInterface
    {
        return $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPerPage
        );
    }
}
