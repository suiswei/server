<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
    
            'customer_uuid' => $this->customer->uuid,
            'customer_name' => $this->customer->name,
    
            'total_price' => $this->total_amount,
    
            'items' => $this->items->map(function ($item) {
                return [
                    'product_uuid' => $item->product->uuid,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->quantity * $item->unit_price
                ];
            })
        ];
    }
    
}