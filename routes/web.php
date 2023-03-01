<?php

use App\Http\Controllers\Admin\Blog\BlogCategoryController;
use App\Http\Controllers\Admin\Blog\BlogPostController;
use App\Http\Controllers\Admin\Blog\BlogCommentController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Blog\CommentController;
use Illuminate\Support\Facades\Route;
use Takshak\Adash\Http\Middleware\GatesMiddleware;
use Takshak\Adash\Http\Middleware\ReferrerMiddleware;

Route::middleware('web')->group(function () {
    if (config('site.blog.routes.sections.front', true)) {
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::prefix('posts')->name('posts.')->controller(PostController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('show/{post:slug}', 'show')->name('show');
            });
            Route::prefix('comments')->name('comments.')->group(function () {
                Route::post('replies/{blogComment}', [CommentController::class, 'ajaxReplies'])->name('replies');
                Route::post('store/{post}', [CommentController::class, 'store'])->name('store');
            });
        });
    }

    # admin routes
    if (config('site.blog.routes.sections.admin', true)) {
        Route::middleware(['auth', GatesMiddleware::class, ReferrerMiddleware::class])
            ->prefix('admin')
            ->name('admin.')
            ->group(function () {
                Route::prefix('blog')->name('blog.')->group(function () {
                    Route::resource('categories', BlogCategoryController::class);
                    Route::prefix('categories')->name('categories.')->group(function () {
                        Route::get('status-toggle/{category}', [BlogCategoryController::class, 'statusToggle'])->name('status-toggle');
                        Route::get('featured-toggle/{category}', [BlogCategoryController::class, 'featuredToggle'])->name('featured-toggle');
                    });

                    Route::resource('posts', BlogPostController::class);
                    Route::prefix('posts')->name('posts.')->group(function () {
                        Route::get('status-toggle/{post}', [BlogPostController::class, 'statusToggle'])->name('status-toggle');
                        Route::get('featured-toggle/{post}', [BlogPostController::class, 'featuredToggle'])->name('featured-toggle');
                    });

                    Route::resource('comments', BlogCommentController::class)->except(['create', 'store']);
                });
            });
    }
});
