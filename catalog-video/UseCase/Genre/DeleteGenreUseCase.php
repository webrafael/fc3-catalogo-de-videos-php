<?php namespace CatalogVideo\UseCase\Genre;

use CatalogVideo\Domain\Repository\GenreRepositoryInterface;
use CatalogVideo\UseCase\DTO\Genre\Delete\DeleteGenreOutputDto;
use CatalogVideo\UseCase\DTO\Genre\GenreInputDto;

class DeleteGenreUseCase
{
    protected $repository;

    public function __construct(GenreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GenreInputDto $input): DeleteGenreOutputDto
    {
        $success = $this->repository->delete($input->id);

        return new DeleteGenreOutputDto(
            success: $success
        );
    }
}
