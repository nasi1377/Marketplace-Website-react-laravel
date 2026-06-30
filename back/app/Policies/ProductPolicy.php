<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function browse(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('easy_3_supplier');
    }

    public function read(User $user, Product $product)
    {
        if ($user->hasRole('admin')) return true;
        return $user->id === $product->supplier_id;
    }

    public function edit(User $user, Product $product)
    {
        if ($user->hasRole('admin')) return true;
        return $user->id === $product->supplier_id;
    }

    public function add(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('easy_3_supplier');
    }

    public function delete(User $user, Product $product)
    {
        if ($user->hasRole('admin')) return true;
        return $user->id === $product->supplier_id;
    }
}
