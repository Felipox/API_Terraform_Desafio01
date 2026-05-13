<?php

namespace App\Policies;

use App\Domain\Comment\Dto\CommentDto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function modify(User $user, CommentDto $comment):Response{
        
        return $user->id === $comment->author_id 
        ? Response::allow()
        : Response::deny('Esse commentario não é seu');
    }
}
