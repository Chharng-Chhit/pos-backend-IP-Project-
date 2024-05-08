<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductsType extends Model
{
    use HasFactory;
    protected $table = 'category';

    public function product(): HasMany //1:M
    {
        return $this->hasMany(Product::class, 'type_id', 'id');
    }
}
