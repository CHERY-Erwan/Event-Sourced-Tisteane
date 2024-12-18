<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = ['user_uuid', 'session_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_uuid', 'uuid');
    }
}
