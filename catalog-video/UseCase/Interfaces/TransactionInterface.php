<?php namespace CatalogVideo\UseCase\Interfaces;

interface TransactionInterface
{
    public function commit();

    public function rollback();
}
