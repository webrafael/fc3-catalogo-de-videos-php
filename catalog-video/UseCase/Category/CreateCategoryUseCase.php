<?php namespace CatalogVideo\UseCase\Category;

use CatalogVideo\Domain\Entity\Category;
use CatalogVideo\Domain\Repository\CategoryRepositoryInterface;
use CatalogVideo\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;
use CatalogVideo\UseCase\DTO\Category\CreateCategory\CategoryCreateOutputDto;

class CreateCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryCreateInputDto $input): CategoryCreateOutputDto
    {
        $category = new Category(
            name: $input->name,
            description: $input->description,
            isActive: $input->isActive,
        );

        $newCategory = $this->repository->insert($category);

        return new CategoryCreateOutputDto(
            id: $newCategory->id(),
            name: $newCategory->name,
            description: $category->description,
            is_active: $category->isActive,
            created_at: $category->createdAt(),
        );
    }
}
