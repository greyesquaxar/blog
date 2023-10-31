<?php

namespace App\Policies;

use App\User;
use App\ArticleImage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleImagePolicy
{
    use HandlesAuthorization;

    public function delete(User $user, ArticleImage $imagen)
    {
        return $user->id === $imagen->article->user_id;
    }

}
