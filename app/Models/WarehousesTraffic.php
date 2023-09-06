<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehousesTraffic extends Model {

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'qty',
        'type_id',
    ];

    public function warehouse() {
        return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public static function store(array $inputData) {
        $item = new self();

        $item->fill($inputData);

        if($item->save()) {
            WarehousesBalance::recalculateProductQty($item);
            return true;
        }

        return false;
    }
}
