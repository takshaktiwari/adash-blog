<?php

namespace Takshak\Ablog;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Takshak\Ablog\Console\InstallCommand;

class AblogServiceProvider extends ServiceProvider
{
	public function boot()
	{
	    if (!$this->app->runningInConsole()) {
	        return;
	    }

	    $this->commands([ InstallCommand::class ]);
	    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
	    $this->loadViewsFrom(__DIR__.'/../resources/views', 'ablog');

	    $this->publishFiles();
	}

	public function publishFiles()
	{
		
	}
}