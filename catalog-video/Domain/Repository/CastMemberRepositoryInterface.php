<?php namespace CatalogVideo\Domain\Repository;

use CatalogVideo\Domain\Entity\CastMember;

interface CastMemberRepositoryInterface
{
    public function insert(CastMember $castMember): CastMember;
    public function findById(string $castMemberId): CastMember;
    public function getIdsListIds(array $castMembersIds = []): array;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;
    public function update(CastMember $castMember): CastMember;
    public function delete(string $castMemberId): bool;
}
