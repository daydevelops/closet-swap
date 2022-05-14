<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function like(User $user,Product $product) {
        return !$product->liked && $product->user_id != $user->id;
    }

    public function unlike(User $user,Product $product) {
        return $product->liked && $product->user_id != $user->id;
    }

    public function edit(User $user,Product $product) {
        return $this->isOwner($user,$product);
    }

    public function delete(User $user,Product $product) {
        return $this->isOwner($user,$product);
    }

    private function isOwner(User $user,Product $product) {
        return $user->id == $product->user_id;
    }
}
