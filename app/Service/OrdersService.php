<?php

namespace App\Service;

use App\Repository\OrdersRepository;
use App\Repository\CustomerRepository;
use App\Http\Resources\OrdersResource;

class OrdersService
{
    private OrdersRepository $ordersRepository;
    private CustomerRepository $customerRepository;


    public function __construct(
        OrdersRepository $ordersRepository,
        CustomerRepository $customerRepository
        ) 
        
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function listOrders(int $perPage = 15)
    {
        $collection = $this->ordersRepository->paginate($perPage);
        return OrdersResource::collection($collection);
    }

    public function createOrders(array $payload)
    {
        $model = $this->ordersRepository->create($payload);
        return new OrdersResource($model);
    }

    public function getOrders(string $uuid)
    {
        $model = $this->ordersRepository->findByUuid($uuid);
        return new OrdersResource($model);
    }

    public function getOrdersByField(string $field, $value)
    {
        $model = $this->ordersRepository->findByField($field, $value);
        return new OrdersResource($model);
    }

    public function updateOrders(string $uuid, array $payload)
    {
        $model = $this->ordersRepository->update($uuid, $payload);
        return new OrdersResource($model);
    }

    public function deleteOrders(string $uuid)
    {
        $this->ordersRepository->delete($uuid);
        return true;
    }

    public function restoreOrders(string $uuid)
    {
        $model = $this->ordersRepository->restore($uuid);
        return new OrdersResource($model);
    }
}