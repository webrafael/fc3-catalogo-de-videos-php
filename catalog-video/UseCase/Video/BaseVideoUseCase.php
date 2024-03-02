<?php namespace CatalogVideo\UseCase\Video;

use CatalogVideo\Domain\Builder\Video\Builder;
use CatalogVideo\Domain\Enum\{
    MediaStatus
};
use CatalogVideo\Domain\Events\VideoCreatedEvent;
use CatalogVideo\Domain\Exceptions\NotFoundException;
use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\Domain\Repository\CategoryRepositoryInterface;
use CatalogVideo\Domain\Repository\GenreRepositoryInterface;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\UseCase\Interfaces\FileStorageInterface;
use CatalogVideo\UseCase\Interfaces\TransactionInterface;
use CatalogVideo\UseCase\Video\Interfaces\VideoEventManagerInterface;

abstract class BaseVideoUseCase
{
    protected Builder $builder;

    public function __construct(
        protected VideoRepositoryInterface $repository,
        protected TransactionInterface $transaction,
        protected FileStorageInterface $storage,
        protected VideoEventManagerInterface $eventManager,

        protected CategoryRepositoryInterface $repositoryCategory,
        protected GenreRepositoryInterface $repositoryGenre,
        protected CastMemberRepositoryInterface $repositoryCastMember,
    ) {
        $this->builder = $this->getBuilder();
    }

    abstract protected function getBuilder(): Builder;

    protected function storageFiles(object $input): void
    {
        $entity = $this->builder->getEntity();
        $path = $entity->id();

        if ($pathVideoFile = $this->storageFile($path, $input->videoFile)) {
            $this->builder->addMediaVideo($pathVideoFile, MediaStatus::PROCESSING);
            $this->eventManager->dispatch(new VideoCreatedEvent($entity));
        }

        if ($pathTrailerFile = $this->storageFile($path, $input->trailerFile)) {
            $this->builder->addTrailer($pathTrailerFile);
        }

        if ($pathThumbFile = $this->storageFile($path, $input->thumbFile)) {
            $this->builder->addThumb($pathThumbFile);
        }

        if ($pathThumbHalfFile = $this->storageFile($path, $input->thumbHalf)) {
            $this->builder->addThumbHalf($pathThumbHalfFile);
        }

        if ($pathBannerFile = $this->storageFile($path, $input->bannerFile)) {
            $this->builder->addBanner($pathBannerFile);
        }
    }

    protected function storageFile(string $path, ?array $media = null): null|string
    {
        if ($media) {
            return $this->storage->store(
                path: $path,
                file: $media,
            );
        }

        return null;
    }

    protected function validateAllIds(object $input)
    {
        $this->validateIds(
            ids: $input->categories,
            repository: $this->repositoryCategory,
            singularLabel: 'Category',
            pluralLabel: 'Categories'
        );

        $this->validateIds(
            ids: $input->genres,
            repository: $this->repositoryGenre,
            singularLabel: 'Genre',
        );

        $this->validateIds(
            ids: $input->castMembers,
            repository: $this->repositoryCastMember,
            singularLabel: 'Cast Member',
        );
    }

    protected function validateIds(array $ids, $repository, string $singularLabel, ?string $pluralLabel = null)
    {
        $idsDb = $repository->getIdsListIds($ids);

        $arrayDiff = array_diff($ids, $idsDb);

        if (count($arrayDiff)) {
            $msg = sprintf(
                '%s %s not found',
                count($arrayDiff) > 1 ? $pluralLabel ?? $singularLabel.'s' : $singularLabel,
                implode(', ', $arrayDiff)
            );

            throw new NotFoundException($msg);
        }
    }
}
