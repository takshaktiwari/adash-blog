<?php

namespace Takshak\Ablog;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Takshak\Ablog\Console\InstallCommand;

class AblogServiceProvider extends ServiceProvider
{
	public function boot()
	{
	    $this->commands([ InstallCommand::class ]);
	    $this->loadViewsFrom(__DIR__.'/../resources/views', 'ablog');
	    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
	    $this->publishFiles();
	}

	public function publishFiles()
	{
		
	}
}