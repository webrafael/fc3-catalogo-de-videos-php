<?php namespace App\Repositories\Transaction;

use Illuminate\Support\Facades\DB;
use CatalogVideo\UseCase\Interfaces\TransactionInterface;

class DBTransaction implements TransactionInterface
{
    public function __construct()
    {
        DB::beginTransaction();
    }

    public function commit()
    {
        DB::commit();
    }

    public function rollback()
    {
        DB::rollBack();
    }
}
