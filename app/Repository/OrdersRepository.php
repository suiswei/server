<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repository\CustomerRepository;

class OrdersRepository
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function paginate(int $perPage = 15)
    {
        return Order::latest()->paginate($perPage);
    }

    public function create(array $payload)
    {
        return Order::create($payload);
    }

    public function findByUuid(string $uuid)
    {
        return Order::where('uuid', $uuid)->firstOrFail();
    }

    public function findByField(string $field, $value)
    {
        return Order::where($field, $value)->firstOrFail();
    }

    public function addItem(Order $order, array $payload)
    {
        return $order->items()->create([
            'product_id' => $payload['product_id'],
            'quantity'   => $payload['quantity'],
            'unit_price' => $payload['unit_price'],
        ]);
    }

    public function updateTotal(Order $order, float $totalAmount)
    {
        $order->total_amount = $totalAmount;
        $order->save();

        return $order;
    }

    public function delete(string $uuid)
    {
        $model = $this->findByUuid($uuid);
        return $model->delete();
    }

    public function restore(string $uuid)
    {
        $model = Order::withTrashed()->where('uuid', $uuid)->firstOrFail();
        $model->restore();
        return $model;
    }

}