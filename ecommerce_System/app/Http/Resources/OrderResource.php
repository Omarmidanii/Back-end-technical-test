<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => Auth::user()->firstname . " " . Auth::user()->lastname,
            'total_price' => $this->total_price,
            'products' => $this->whenLoaded('products', function () {
                return ProductResource::collection($this->products);
            }),
        ];
    }
}
