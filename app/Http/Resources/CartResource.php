<?php

namespace App\Http\Resources;

use App\Helper\CartHelper;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$products, $cartItems] = $this->resource;
        $productsCollection = collect($products);
        return [
            'count' => CartHelper::getCount(),
            'total'=> $productsCollection->reduce(fn (?float $carry, Product $product)=> $carry + $product->price * $cartItems[$product->id]['quantity']),
            'items'=> $cartItems,
            'products' => ProductResource::collection($products)
        ];
    }
}
