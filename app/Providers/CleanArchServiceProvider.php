<?php

namespace App\Providers;

use App\Events\VideoEvent;
use App\Services\AMQP\AMQPInterface;
use App\Services\AMQP\PhpAmqpService;
use App\Services\Storage\FileStorage;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Transaction\DBTransaction;
use App\Repositories\Eloquent\GenreEloquentRepository;
use App\Repositories\Eloquent\VideoEloquentRepository;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use CatalogVideo\UseCase\Interfaces\FileStorageInterface;
use CatalogVideo\UseCase\Interfaces\TransactionInterface;
use App\Repositories\Eloquent\CastMemberEloquentRepository;
use CatalogVideo\Domain\Repository\GenreRepositoryInterface;
use CatalogVideo\Domain\Repository\VideoRepositoryInterface;
use CatalogVideo\Domain\Repository\CategoryRepositoryInterface;
use CatalogVideo\Domain\Repository\CastMemberRepositoryInterface;
use CatalogVideo\UseCase\Video\Interfaces\VideoEventManagerInterface;

class CleanArchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->bingRepositories();

        $this->app->singleton(
            FileStorageInterface::class,
            FileStorage::class,
        );

        $this->app->singleton(
            VideoEventManagerInterface::class,
            VideoEvent::class
        );

        /**
         * DB Transaction
         */
        $this->app->bind(
            TransactionInterface::class,
            DBTransaction::class,
        );

        /**
         * Services
         */
        $this->app->bind(
            AMQPInterface::class,
            PhpAmqpService::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function bingRepositories()
    {
        /**
         * Repositories
         */
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryEloquentRepository::class
        );
        $this->app->singleton(
            GenreRepositoryInterface::class,
            GenreEloquentRepository::class
        );
        $this->app->singleton(
            CastMemberRepositoryInterface::class,
            CastMemberEloquentRepository::class
        );
        $this->app->singleton(
            VideoRepositoryInterface::class,
            VideoEloquentRepository::class
        );
    }
}
