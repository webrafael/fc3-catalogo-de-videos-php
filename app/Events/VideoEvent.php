<?php namespace App\Events;

use CatalogVideo\UseCase\Video\Interfaces\VideoEventManagerInterface;

class VideoEvent implements VideoEventManagerInterface
{
    public function dispatch(object $event): void
    {
        event($event);
    }
}
