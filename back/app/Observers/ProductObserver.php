<?php

namespace App\Observers;

use App\Models\Product;
use App\Jobs\SyncProductEmbedding;

class ProductObserver
{
    public function created(Product $product): void
    {
        SyncProductEmbedding::dispatch($product->id);
    }

    public function updated(Product $product): void
    {
        SyncProductEmbedding::dispatch($product->id);
    }

    public function deleted(Product $product): void
    {
        // TODO: حذف از Qdrant (vector DB)
    }
}