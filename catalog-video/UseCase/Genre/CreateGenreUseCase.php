<?php namespace CatalogVideo\UseCase\Genre;

use CatalogVideo\Domain\Entity\Genre;
use CatalogVideo\Domain\Exception\NotFoundException;
use CatalogVideo\Domain\Repository\CategoryRepositoryInterface;
use CatalogVideo\Domain\Repository\GenreRepositoryInterface;
use CatalogVideo\UseCase\DTO\Genre\Create\GenreCreateInputDto;
use CatalogVideo\UseCase\DTO\Genre\Create\GenreCreateOutputDto;
use CatalogVideo\UseCase\Interfaces\TransactionInterface;

class CreateGenreUseCase
{
    protected $repository;

    protected $transaction;

    protected $categoryRepository;

    public function __construct(
        GenreRepositoryInterface $repository,
        TransactionInterface $transaction,
        CategoryRepositoryInterface $categoryRepository,
    ) {
        $this->repository = $repository;
        $this->transaction = $transaction;
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(GenreCreateInputDto $input): GenreCreateOutputDto
    {
        try {
            $genre = new Genre(
                name: $input->name,
                isActive: $input->isActive,
                categoriesId: $input->categoriesId
            );

            $this->validateCategoriesId($input->categoriesId);

            $genreDb = $this->repository->insert($genre);

            $this->transaction->commit();

            return new GenreCreateOutputDto(
                id: (string) $genreDb->id,
                name: $genreDb->name,
                is_active: $genreDb->isActive,
                created_at: $genreDb->createdAt(),
            );
        } catch (\Throwable $th) {
            $this->transaction->rollback();
            throw $th;
        }
    }

    public function validateCategoriesId(array $categoriesId = [])
    {
        $categoriesDb = $this->categoryRepository->getIdsListIds($categoriesId);

        $arrayDiff = array_diff($categoriesId, $categoriesDb);

        if (count($arrayDiff)) {
            $msg = sprintf(
                '%s %s not found',
                count($arrayDiff) > 1 ? 'Categories' : 'Category',
                implode(', ', $arrayDiff)
            );

            throw new NotFoundException($msg);
        }
    }
}
