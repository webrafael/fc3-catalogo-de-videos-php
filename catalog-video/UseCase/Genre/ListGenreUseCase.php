<?php namespace CatalogVideo\UseCase\Genre;

use CatalogVideo\Domain\Repository\GenreRepositoryInterface;
use CatalogVideo\UseCase\DTO\Genre\GenreInputDto;
use CatalogVideo\UseCase\DTO\Genre\GenreOutputDto;

class ListGenreUseCase
{
    protected $repository;

    public function __construct(GenreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GenreInputDto $input): GenreOutputDto
    {
        $genre = $this->repository->findById(genreId: $input->id);

        return new GenreOutputDto(
            id: (string) $genre->id,
            name: $genre->name,
            is_active: $genre->isActive,
            created_at: $genre->createdAt(),
        );
    }
}
