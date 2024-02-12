<?php namespace CatalogVideo\UseCase\Video\Create;

use CatalogVideo\Domain\Builder\Video\Builder;
use CatalogVideo\Domain\Builder\Video\BuilderVideo;
use CatalogVideo\UseCase\Video\BaseVideoUseCase;
use CatalogVideo\UseCase\Video\Create\DTO\CreateInputVideoDTO;
use CatalogVideo\UseCase\Video\Create\DTO\CreateOutputVideoDTO;
use Throwable;

class CreateVideoUseCase extends BaseVideoUseCase
{
    protected function getBuilder(): Builder
    {
        return new BuilderVideo;
    }

    public function exec(CreateInputVideoDTO $input): CreateOutputVideoDTO
    {
        $this->validateAllIds($input);

        $this->builder->createEntity($input);

        try {
            $this->repository->insert($this->builder->getEntity());

            $this->storageFiles($input);

            $this->repository->updateMedia($this->builder->getEntity());

            $this->transaction->commit();

            return $this->output();
        } catch (Throwable $th) {
            $this->transaction->rollback();
            // if (isset($pathMedia)) $this->storage->delete($pathMedia);
            throw $th;
        }
    }

    private function output(): CreateOutputVideoDTO
    {
        $entity = $this->builder->getEntity();

        return new CreateOutputVideoDTO(
            id: $entity->id(),
            title: $entity->title,
            description: $entity->description,
            yearLaunched: $entity->yearLaunched,
            duration: $entity->duration,
            opened: $entity->opened,
            rating: $entity->rating,
            createdAt: $entity->createdAt(),
            categories: $entity->categoriesId,
            genres: $entity->genresId,
            castMembers: $entity->castMemberIds,
            videoFile: $entity->videoFile()?->filePath,
            trailerFile: $entity->trailerFile()?->filePath,
            thumbFile: $entity->thumbFile()?->path(),
            thumbHalf: $entity->thumbHalf()?->path(),
            bannerFile: $entity->bannerFile()?->path(),
        );
    }
}
