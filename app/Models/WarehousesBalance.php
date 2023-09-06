<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehousesBalance extends Model {

    protected $table = 'warehouses_balance';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'qty',
    ];


    public function warehouse() {
        return $this->hasOne(Warehouse::class, 'id', 'warehouse_id');
    }

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public static function recalculateProductQty(WarehousesTraffic $warehousesTraffic) {
        $item = self::where('product_id', $warehousesTraffic->product_id)
            ->where('warehouse_id', $warehousesTraffic->warehouse_id)
            ->first();

        if(!$item) {
            $item = new self();
            $item->fill($warehousesTraffic->toArray());
        } else {
            switch ($warehousesTraffic->type_id) {
                // приход
                case 1:
                    $item->qty += $warehousesTraffic->qty;
                    break;
                // расход
                case 2:
                    $item->qty -= $warehousesTraffic->qty;
                    break;
            }
        }

        return $item->save();
    }
}
