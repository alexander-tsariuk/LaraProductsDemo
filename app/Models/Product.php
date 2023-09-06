<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $fillable = [
        'name',
        'article',
        'price'
    ];

    protected $with = [
        'qty'
    ];

    protected $appends = [
        'qty'
    ];

    public function qty() {
        return $this->hasMany(WarehousesBalance::class, 'product_id', 'id');

    }

    public function getQtyAttribute() {
        return $this->qty()->sum('qty');
    }
}
