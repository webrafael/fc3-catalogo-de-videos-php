<?php namespace CatalogVideo\UseCase\Video\Update;

use CatalogVideo\Domain\Builder\Video\Builder;
use CatalogVideo\Domain\Builder\Video\UpdateVideoBuilder;
use CatalogVideo\UseCase\Video\BaseVideoUseCase;
use CatalogVideo\UseCase\Video\Update\DTO\UpdateInputVideoDTO;
use CatalogVideo\UseCase\Video\Update\DTO\UpdateOutputVideoDTO;
use Throwable;

class UpdateVideoUseCase extends BaseVideoUseCase
{
    protected function getBuilder(): Builder
    {
        return new UpdateVideoBuilder;
    }

    public function exec(UpdateInputVideoDTO $input): UpdateOutputVideoDTO
    {
        $this->validateAllIds($input);

        $entity = $this->repository->findById($input->id);
        $entity->update(
            title: $input->title,
            description: $input->description,
        );

        $this->builder->setEntity($entity);
        $this->builder->addIds($input);

        try {
            $this->repository->update($this->builder->getEntity());

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

    private function output(): UpdateOutputVideoDTO
    {
        $entity = $this->builder->getEntity();

        return new UpdateOutputVideoDTO(
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
