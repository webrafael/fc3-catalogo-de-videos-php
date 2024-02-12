<?php namespace CatalogVideo\Domain\Repository;

use CatalogVideo\Domain\Entity\Category;
use CatalogVideo\Domain\Repository\PaginationInterface;

interface CategoryRepositoryInterface
{
    public function insert(Category $category): Category;
    public function findById(string $categoryId): Category;
    public function getIdsListIds(array $categoriesId = []): array;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;
    public function update(Category $category): Category;
    public function delete(string $categoryId): bool;
}