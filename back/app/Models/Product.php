<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'products';

    // ثابت برای وضعیت منتشر شده (اگر در دیتابیس کلمه دیگری استفاده می‌کنی آن را تغییر بده)
    const PUBLISHED = 'PUBLISHED';
    
    protected $fillable = [
        'supplier_id', 
        'title', 
        'price', 
        'stock', 
        'image', 
        'status', 
        'author_id', 
        'excerpt', 
        'body', 
        'slug'
    ];

    public function save(array $options = [])
    {
        // تنظیم خودکار آیدی نویسنده هنگام ذخیره
        if (!$this->author_id && Auth::check()) {
            $this->author_id = Auth::id();
        }
        return parent::save($options);
    }

    protected static function boot()
    {
        parent::boot();

        // ساخت خودکار اسلاگ (Slug) هنگام ایجاد محصول
        static::creating(function ($product) {
            if (!$product->slug && $product->title) {
                $product->slug = Str::slug($product->title);
            }
        });

        // آپدیت اسلاگ در صورت تغییر نام
        static::updating(function ($product) {
            if ($product->isDirty('title')) {
                $product->slug = Str::slug($product->title);
            }
        });

        static::saved(function ($product) {
            // مدیریت تنوع محصولات (Variations)
            $variations = request()->get('variations');
            if ($variations && is_array($variations)) {
                $product->variations()->delete();
                foreach (array_values($variations) as $var) {
                    if (!empty($var['size']) || !empty($var['color']) || !empty($var['stock'])) {
                        $product->variations()->create([
                            'stock' => $var['stock'] ?? 0,
                            'size'  => $var['size'] ?? null,
                            'color' => $var['color'] ?? null,
                        ]);
                    }
                }
            }
        });
    }

    // ارتباط با جدول تنوع محصولات
    public function variations()
    {
        return $this->hasMany(\App\Models\ProductVariation::class, 'product_id', 'id');
    }

    // اسکوپ برای محصولات منتشر شده
    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', self::PUBLISHED);
    }

    // محدود کردن مشاهده محصولات برای تامین‌کننده (Supplier)
    public function scopeCurrentUser($query)
    {
        if (Auth::check() && Auth::user()->hasRole('easy_3_supplier')) {
            return $query->where('supplier_id', Auth::id());
        }
        return $query;
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

