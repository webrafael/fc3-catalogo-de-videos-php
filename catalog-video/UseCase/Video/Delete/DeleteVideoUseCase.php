<?php namespace CatalogVideo\UseCase\Video\Delete;

use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Video\Delete\DTO\DeleteInputVideoDTO;
use CatalogVideo\UseCase\Video\Delete\DTO\DeleteOutputVideoDTO;

class DeleteVideoUseCase
{
    public function __construct(
        private VideoRepositoryInterface $repository,
    ) {
    }

    public function exec(DeleteInputVideoDTO $input): DeleteOutputVideoDTO
    {
        $deleted = $this->repository->delete($input->id);

        return new DeleteOutputVideoDTO(
            deleted: $deleted
        );
    }
}
