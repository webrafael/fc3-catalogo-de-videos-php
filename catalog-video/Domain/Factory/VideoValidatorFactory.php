<?php namespace CatalogVideo\Domain\Factory;

use CatalogVideo\Domain\Validation\ValidatorInterface;
use CatalogVideo\Domain\Validation\VideoRakitValidator;

class VideoValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        // return new VideoLaravelValidator();
        return new VideoRakitValidator();
    }
}
