<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehousesBalance;
use App\Models\WarehousesTraffic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class WarehousesController extends CrudController {

    public function __construct() {
        $this->model = Warehouse::class;
        $this->route = 'warehouses';
        $this->viewsDirectory = 'warehouses';
        $this->routeItemName = 'warehouse';

        $this->createValidationFields = [
            'name' => 'required|unique:warehouses,name'
        ];

        if(Route::getCurrentRoute()->hasParameter($this->routeItemName)) {
            $this->updateValidationFields = [
                'name' => 'required|unique:warehouses,name,'.Route::getCurrentRoute()->parameter($this->routeItemName)
            ];
        }
    }


    public function warehousesBalance() {
        $traffic = $balance = null;

        if(\request()->warehouse_id);

        if(\request()->has('warehouse_id') && \request()->has('product_id') && (\request()->warehouse_id != 0 || \request()->product_id != 0)) {
            $traffic = WarehousesTraffic::query()->with(['product', 'warehouse']);
            $balance = WarehousesBalance::query()->with(['product', 'warehouse']);

            if(\request()->has('warehouse_id') && !empty(\request()->warehouse_id)) {
                $traffic->where('warehouse_id', \request()->warehouse_id);
                $balance->where('warehouse_id', \request()->warehouse_id);
            }

            if(\request()->has('product_id') && \request()->product_id) {
                $traffic->where('product_id', \request()->product_id);
                $balance->where('product_id', \request()->product_id);
            }

            $traffic = $traffic->orderBy('id', 'DESC')->get();
            $balance = $balance->orderBy('warehouse_id', 'DESC')->get();
        }

        return view('dashboard.warehouses.balances', [
            'warehouses' => Warehouse::all(),
            'products' => Product::all(),
            'traffic' => $traffic,
            'balance' => $balance,
            'warehouse_id' => \request()->warehouse_id,
            'product_id' => \request()->product_id,
        ]);
    }
}
