<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ProductsController extends CrudController {

    public function __construct() {
        $this->model = Product::class;
        $this->route = 'products';
        $this->viewsDirectory = 'products';
        $this->routeItemName = 'product';

        $this->createValidationFields = [
            'name' => 'required|min:3|max:255',
            'article' => 'required|min:3|max:255|unique:products,article',
            'price' => 'required|numeric|gt:0'
        ];

        if(Route::getCurrentRoute()->hasParameter($this->routeItemName)) {
            $this->updateValidationFields = [
                'name' => 'required|min:3|max:255',
                'price' => 'required|numeric|gt:0'
            ];

            \request()->except('article');
        }
    }
}
