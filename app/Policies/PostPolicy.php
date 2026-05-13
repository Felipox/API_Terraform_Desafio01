<?php

namespace App\Policies;

use App\Domain\Post\Dto\PostDto;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class PostPolicy
{   
    public function modify(User $user, PostDto $post): Response
    {
        
        return $user->id === $post->author_id
            ? Response::allow()
            : Response::deny('Esse post não é seu.');
    }
}
