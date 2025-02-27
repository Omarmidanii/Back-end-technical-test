<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductQuantityAvailable implements ValidationRule
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract the product index from the attribute (e.g., "products.0.quantity" → index 0)
        $segments = explode('.', $attribute);
        $productIndex = $segments[1];

        // Get the product_id from the request data
        $productId = $this->data['products'][$productIndex]['product_id'] ?? null;

        // Find the product (ensure it exists and is not soft-deleted)
        $product = Product::find($productId);
        if ($product && $product->quantity < $value)
            $fail('Insufficient quantity available for the selected product.');
    }
}
