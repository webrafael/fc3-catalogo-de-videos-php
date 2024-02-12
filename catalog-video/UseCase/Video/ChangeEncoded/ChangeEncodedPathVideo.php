<?php

namespace CatalogVideo\UseCase\Video\ChangeEncoded;

use CatalogVideo\Domain\Enum\MediaStatus;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\Domain\ValueObject\Media;
use CatalogVideo\UseCase\Video\ChangeEncoded\DTO\ChangeEncodedVideoDTO;
use CatalogVideo\UseCase\Video\ChangeEncoded\DTO\ChangeEncodedVideoOutputDTO;

class ChangeEncodedPathVideo
{
    public function __construct(
        protected VideoRepositoryInterface $repository
    ) {
    }

    public function exec(ChangeEncodedVideoDTO $input): ChangeEncodedVideoOutputDTO
    {
        $entity = $this->repository->findById($input->id);

        $entity->setVideoFile(
            new Media(
                filePath: $entity->videoFile()?->filePath ?? '',
                mediaStatus: MediaStatus::COMPLETE,
                encodedPath: $input->encodedPath
            )
        );

        $this->repository->updateMedia($entity);

        return new ChangeEncodedVideoOutputDTO(
            id: $entity->id(),
            encodedPath: $input->encodedPath
        );
    }
}
