<?php

namespace Takshak\Ablog;

use Illuminate\Support\ServiceProvider;
use Takshak\Ablog\Console\InstallCommand;
use Illuminate\Pagination\Paginator;

class AblogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([InstallCommand::class]);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ablog');
        $this->loadViewComponentsAs('ablog', [
            View\Components\Blog\PostCard::class,
            View\Components\Blog\PostGallery::class,
            View\Components\Blog\Sidebar::class,
            View\Components\Blog\Comment::class,
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views'),
        ]);

        Paginator::useBootstrap();
        $this->loadRoutes();
    }

    public function loadRoutes()
    {
        if(config('site.blog.routes.default', true)){
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }
    }
}
