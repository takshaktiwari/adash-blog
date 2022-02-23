<?php

namespace Takshak\Ablog\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
	protected $signature = 'adash-blog:install {install=default}';
    protected $stubsPath;
    protected $filesystem;
    protected $str;
    protected $installType;

    public function __construct()
    {
        parent::__construct();
        $this->stubsPath = __DIR__.'/../../stubs';
        $this->filesystem = new Filesystem;
        $this->str = new Str;
    }

	public function handle()
    {
        $stub = $this->filesystem->get($this->stubsPath.'/config/config.stub');
        $targetFile = $this->filesystem->get(config_path('site.php'));
        if (!$this->str->of($targetFile)->contains("'blog'")) {
            $lines = Str::of($targetFile)->beforeLast('];');
            $lines .= "\n";
            $lines .= $stub;
            $lines .= "];\n";
            $this->filesystem->put(config_path('site.php'), $lines);
        }

        if (!config('site.blog.install.command', true)) {
            $this->error('SORRY !! Blog:Install command has been disabled.');
            exit;
        }

        $replacements = [
            [
                $this->stubsPath.'/Models/Blog/BlogCategory.stub',
                app_path('Models/Blog/BlogCategory.php')
            ],
            [
                $this->stubsPath.'/Models/Blog/BlogComment.stub',
                app_path('Models/Blog/BlogComment.php')
            ],
            [
                $this->stubsPath.'/Models/Blog/BlogPost.stub',
                app_path('Models/Blog/BlogPost.php')
            ],

            // Controllers

            [
                $this->stubsPath.'/Http/Controllers/Blog/PostController.stub',
                app_path('Http/Controllers/Blog/PostController.php')
            ],
            [
                $this->stubsPath.'/Http/Controllers/Blog/CommentController.stub',
                app_path('Http/Controllers/Blog/CommentController.php')
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

            // seeders
            [
                $this->stubsPath.'/database/seeders/BlogCategorySeeder.stub',
                database_path('seeders/BlogCategorySeeder.php')
            ],
            [
                $this->stubsPath.'/database/seeders/BlogPostSeeder.stub',
                database_path('seeders/BlogPostSeeder.php')
            ],

            // factories
            [
                $this->stubsPath.'/database/factories/Blog/BlogCategoryFactory.stub',
                database_path('factories/Blog/BlogCategoryFactory.php')
            ],
            [
                $this->stubsPath.'/database/factories/Blog/BlogPostFactory.stub',
                database_path('factories/Blog/BlogPostFactory.php')
            ],
            [
                $this->stubsPath.'/database/factories/Blog/BlogCommentFactory.stub',
                database_path('factories/Blog/BlogCommentFactory.php')
            ],
        ];

        foreach ($replacements as $key => $files) {
            if (count($files) == 2 && $files[0] && $files[1]) {
                $this->filesystem->ensureDirectoryExists(
                    $this->str->of($files[1])->beforeLast('/')
                );

                $this->filesystem->copy($files[0], $files[1]);
            }
        }


        // add routes routes/admin.php
        $stub = $this->filesystem->get($this->stubsPath.'/routes/admin.stub');
        $targetFile = $this->filesystem->get(base_path('routes/admin.php'));
        if (!$this->str->of($targetFile)->contains("Route::prefix('blog')")) {

            $lines = Str::of($targetFile)->beforeLast('});');
            $lines .= $stub;
            $lines .= "});\n";

            $this->filesystem->put(base_path('routes/admin.php'), $lines);
        }

        // add routes routes/web.php
        $stub = $this->filesystem->get($this->stubsPath.'/routes/web.stub');
        $targetFile = $this->filesystem->get(base_path('routes/web.php'));
        if (!$this->str->of($targetFile)->contains("Route::prefix('blog')")) {

            $lines = "<?php\n\n";
            $lines .= "use App\Http\Controllers\Blog\PostController;\n";
            $lines .= "use App\Http\Controllers\Blog\CommentController;\n";
            $lines .= Str::of($targetFile)->after("<?php")->before('require');
            $lines .= $stub."\n\n";
            $lines .= "require";
            $lines .= Str::of($targetFile)->after('require');

            $this->filesystem->put(base_path('routes/web.php'), $lines);
        }

        // add routes to admin sidebar component
        $stub = $this->filesystem->get($this->stubsPath.'/resources/views/sidebar.stub');
        $targetFilePath = resource_path('views/components/admin/sidebar.blade.php');
        $targetFile = $this->filesystem->get($targetFilePath);
        if (!$this->str->of($targetFile)->contains("Manage Blog Posts")) {
            $lines = Str::of($targetFile)->beforeLast('</ul>');
            $lines .= $stub;
            $lines .= "\t\t\t</ul>";
            $lines .= Str::of($targetFile)->afterLast('</ul>');
            $this->filesystem->put($targetFilePath, $lines);
        }

        // add seeders
        $targetFilePath = database_path('seeders/DatabaseSeeder.php');
        $targetFile = $this->filesystem->get($targetFilePath);

        if (!$this->str->of($targetFile)->contains("BlogCategorySeeder")) {
            $lines = Str::of($targetFile)->beforeLast(';');
            $lines .= ";\n";
            $lines .= "\t\t".'$this->call(BlogCategorySeeder::class);'."\n";
            $lines .= "\t\t".'$this->call(BlogPostSeeder::class);'."\n";
            $lines .= Str::of($targetFile)->afterLast(';');

            $this->filesystem->put($targetFilePath, $lines);
        }

        $this->call('migrate');

        $this->newLine();
        $this->line('Seeding blog posts');
        $this->call('db:seed', [
            '--class' => 'BlogCategorySeeder'
        ]);
        $this->call('db:seed', [
            '--class' => 'BlogPostSeeder'
        ]);
    }
}
