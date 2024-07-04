<?php

namespace App\Models;

//==========================================================>> Core Library

use App\Models\Order\OrderDetail as OrderOrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//==========================================================>> Custom Library
use App\Models\User;
use App\Models\OrderDetail;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';

    public function cashier() // M:1
    {
        return $this->belongsTo(User::class, 'cashier_id')
            ->select('id', 'name');
    }

    public function user() // M:1
    {
        return $this->belongsTo(User::class, 'cashier_id')
            ->select('id', 'name');
    }
    public function customer() // M:1
    {
        return $this->belongsTo(User::class, 'customer_id')
            ->select('id', 'name', 'phone', 'email', 'loyalty_points');
    }

    public function details() // 1:M
    {
        return $this->hasMany(OrderDetail::class, 'order_id')
            ->select('*')
            ->with([
                'product:id,name,image'
            ]);
    }
}
