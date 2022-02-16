<?php

namespace Takshak\Ablog;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Takshak\Ablog\Console\InstallCommand;
use Takshak\Ablog\View\Components\Blog\Sidebar;

class AblogServiceProvider extends ServiceProvider
{
	public function boot()
	{
	    $this->commands([ InstallCommand::class ]);
	    $this->loadViewsFrom(__DIR__.'/../resources/views', 'ablog');
	    $this->loadViewComponentsAs('ablog', [
	        PostCard::class,
	        PostGallery::class,
	        Sidebar::class,
	    ]);

	    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    	$this->publishes([
            __DIR__.'/../resources/views' => resource_path('views'),
        ]);
	}

}