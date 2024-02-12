<?php namespace CatalogVideo\UseCase\Category;

use CatalogVideo\Domain\Repository\CategoryRepositoryInterface;
use CatalogVideo\UseCase\DTO\Category\CategoryInputDto;
use CatalogVideo\UseCase\DTO\Category\DeleteCategory\CategoryDeleteOutputDto;

class DeleteCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryInputDto $input): CategoryDeleteOutputDto
    {
        $responseDelete = $this->repository->delete($input->id);

        return new CategoryDeleteOutputDto(
            success: $responseDelete
        );
    }
}
