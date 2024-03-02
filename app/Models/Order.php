<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'orders';

    protected $fillable = [
        'amount',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('amount');
    }

    public function scopeWithProducts($query)
    {
        return $query->select('id', 'amount', 'status')
            ->with([
                'products' => function ($query) {
                    return $query->select('id', 'name', 'price', 'amount');
                }]);
    }
}
