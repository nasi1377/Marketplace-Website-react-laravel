<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Translatable;

class Pcategory extends Model
{
    use HasFactory, Translatable;

    protected $translatable = ['slug', 'name'];

    protected $table = 'pcategories';

    protected $fillable = ['slug', 'name'];

    public function posts()
    {
        return $this->hasMany(Voyager::modelClass('Post'))
            ->published()
            ->orderBy('created_at', 'DESC');
    }

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }

    public function products()
{
    // پارامتر دوم اسم ستون توی جدول محصولات هست
    return $this->hasMany(Product::class, 'product_category_id', 'id');
}
}
