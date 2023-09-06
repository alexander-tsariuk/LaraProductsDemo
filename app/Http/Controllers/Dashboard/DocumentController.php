<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehousesTraffic;
use App\Rules\CheckWarehouseQty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller {

    private $allowedTypes = [
        1 => 'arrival',  // приход
        2 => 'consumption' // расход
    ];

    public function create(string $type) {
        // если содержимое аргумента $type не совпадает - шлём на 404
        if(!in_array($type, $this->allowedTypes)) {
            abort(404);
        }

        return view("dashboard.documents.form", [
            'warehouses' => Warehouse::all(),
            'products' => Product::all(),
            'typeId' => array_search($type, $this->allowedTypes)
        ]);
    }

    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            'type_id' => 'required|integer|in:1,2',
            'product_id' => 'required|integer|exists:products,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'qty' => [
                'required',
                'min:0',
                'not_in:0',
                new CheckWarehouseQty(
                    $request->get('warehouse_id'),
                    $request->get('product_id'),
                    $request->get('qty', 0),
                    $request->get('type_id')
                )
            ]
        ]);

        if($validation->fails()) {
            return redirect()->route('document-create', ['type' => $this->allowedTypes[$request->get('type_id')]])
                ->withErrors($validation)
                ->withInput($request->input());
        }

        if(WarehousesTraffic::store($request->all())) {
            $message = 'Документ ';
            $message .= $request->get('type_id') == 1 ? 'прихода' : 'расхода';
            $message .= ' товара успешно добавлен!';

            return redirect()->route('document-create', ['type' => $this->allowedTypes[$request->get('type_id')]])
                ->with('successMessage', $message);
        } else {
            $message = 'При добавлении документа ';
            $message .= $request->get('type_id') == 1 ? 'прихода' : 'расхода';
            $message .= ' товара произошла ошибка. Повторите попытку позже!';

            return redirect()->route('document-create', ['type' => $this->allowedTypes[$request->get('type_id')]])
                ->withInput($request->input())
                ->with('errorMessage', $message);
        }
    }


}
