<?php

namespace App\Repository;

use App\Models\Orders;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrdersRepository
{
    public function paginate(int $perPage = 15)
    {
        return Orders::latest()->paginate($perPage);
    }

    public function create(array $payload)
    {
        return Orders::create($payload);
    }

    public function findByUuid(string $uuid)
    {
        return Orders::where('uuid', $uuid)->firstOrFail();
    }

    public function findByField(string $field, $value)
    {
        return Orders::where($field, $value)->firstOrFail();
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
        $model = Orders::withTrashed()->where('uuid', $uuid)->firstOrFail();
        $model->restore();
        return $model;
    }
}