<?php

namespace App\Providers;

use App\Domain\Comment\Dto\CommentDto;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Infrastructure\Eloquent\PostRepository;
use App\Infrastructure\Eloquent\CommentRepository;
use App\Domain\Post\PostRepositoryInterface;
use App\Domain\Comment\CommentRepositoryInterface;
use App\Domain\Post\Dto\PostDto;
use App\Domain\Users\UserRepositoryInterface;
use App\Infrastructure\Eloquent\UserRepository;
use App\Policies\PostPolicy;
use App\Policies\CommentPolicy;


class AppServiceProvider extends ServiceProvider
{
    
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(PostDto::class, PostPolicy::class);
        Gate::policy(CommentDto::class, CommentPolicy::class);
    }
}
