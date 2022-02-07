<?php

namespace Takshak\Ablog\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
	protected $signature = 'ablog:install {install=default}';
    protected $stubsPath;
    protected $filesystem;
    protected $installType;

    public function __construct()
    {
        parent::__construct();
        $this->stubsPath = __DIR__.'/../../stubs';
        $this->filesystem = new Filesystem;
    }

	public function handle()
    {
        $replacements = [
            [
                $this->stubsPath.'/Models/BlogCategory.stub',
                app_path('Models/BlogCategory.php')
            ],
            [
                $this->stubsPath.'/Models/BlogComment.stub',
                app_path('Models/BlogComment.php')
            ],
            [
                $this->stubsPath.'/Models/BlogPost.stub',
                app_path('Models/BlogPost.php')
            ],
            [
                $this->stubsPath.'/Http/Controllers/Admin/BlogCategoryController.stub',
                app_path('Http/Controllers/Admin/Blog/BlogCategoryController.php')
            ],
            [
                $this->stubsPath.'/Http/Controllers/Admin/BlogCommentController.stub',
                app_path('Http/Controllers/Admin/Blog/BlogCommentController.php')
            ],
            [
                $this->stubsPath.'/Http/Controllers/Admin/BlogPostController.stub',
                app_path('Http/Controllers/Admin/Blog/BlogPostController.php')
            ],
        ];

        foreach ($replacements as $key => $files) {
            if (count($files) == 2 && $files[0] && $files[1]) {
                $this->filesystem->copy($files[0], $files[1]);
            }
        }
    }
}