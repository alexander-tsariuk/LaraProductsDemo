<?php

namespace App\Rules;

use App\Models\WarehousesBalance;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckWarehouseQty implements ValidationRule
{
    /**
     * ID товара
     * @var int
     */
    private int $productId;
    /**
     * ID склада
     * @var int
     */
    private int $warehouseId;
    /**
     * Кол-во товара
     * @var int
     */
    private int $qty;
    /**
     * Тип документа 1 - приход, 2 - расход
     * @var int
     */
    private int $documentType;

    public function __construct(int $warehouseId, int $productId, int $qty, int $documentType) {
        $this->warehouseId = $warehouseId;

        $this->productId = $productId;

        $this->qty = $qty;

        $this->documentType = $documentType;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if($this->documentType == 2) {
            $warehouseBalance = WarehousesBalance::where('warehouse_id', $this->warehouseId)
                ->where('product_id', $this->productId)
                ->first();

            if(!empty($warehouseBalance)) {
                if($warehouseBalance->qty < $this->qty) {
                    $fail('The :attribute must be less than or equal to the value in the database');
                }
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a date in the future.';
    }
}
