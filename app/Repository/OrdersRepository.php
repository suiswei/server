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

    public function getCustomerOrders(int $customerId)
    {
        $customer = $this->customerRepository->findById($customerId);

        return Order::where('customer_id', $customer->id)
        ->with('items.product')
        ->get();
    }

    public function paginate(int $perPage = 15)
    {
        return Order::latest()->paginate($perPage);
    }

    public function findByUuid(string $uuid)
    {
        return Order::where('uuid', $uuid)->firstOrFail();
    }

    public function findByField(string $field, $value)
    {
        return Order::where($field, $value)->firstOrFail();
    }

    public function update(string $uuid, array $payload)
    {
        $model = $this->findByUuid($uuid);
        $model->update($payload);
        return $model;
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

    public function create(array $payload)
    {
        return DB::transaction(function () use ($payload) {

            $totalAmount = 0;

            $order = Order::create([
                'customer_id' => $payload['customer_id'],
                'total_amount' => 0
            ]);

            foreach ($payload['items'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $unitPrice = $product->price;
                $subtotal = $unitPrice * $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice
                ]);

                $totalAmount += $unitPrice * $item['quantity'];
            }

            $order->update([
                'total_amount' => $totalAmount
            ]);

            return $order->load('items.product');
        });
    }
}