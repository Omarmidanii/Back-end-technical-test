<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {

            $total_price = 0;
            foreach ($data['products'] as $item) {
                $product = Product::where('id', $item['product_id'])->first();
                $total_price += $item['quantity'] * $product->price;
            }
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total_price
            ]);

            foreach ($data['products'] as $item) {
                $product = Product::where('id', $item['product_id'])
                    ->lockForUpdate()
                    ->first();

                if ($product->quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'quantity' => "Insufficient stock for {$product->name}",
                    ]);
                }
                $product->decrement('quantity', $item['quantity']);
                $order->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            return $order;
        });
    }
}
