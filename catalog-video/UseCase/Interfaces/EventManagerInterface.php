<?php namespace CatalogVideo\UseCase\Interfaces;

interface EventManagerInterface
{
    public function dispatch(object $event): void;
}
