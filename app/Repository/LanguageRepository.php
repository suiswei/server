<?php

namespace App\Repository;

use App\Models\Language;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LanguageRepository
{
    public function paginate(int $perPage = 15)
    {
        return Language::latest()->paginate($perPage);
    }

    public function create(array $payload)
    {
        return Language::create($payload);
    }

    public function findById(int $id)
    {
        return Language::where('id', $id)->first();
    }

    public function findByField(string $field, $value)
    {
        return Language::where($field, $value)->firstOrFail();
    }

    public function update(int $id, array $payload)
    {
        $model = $this->findById($id);
        $model->update($payload);
        return $model;
    }

    public function delete(string $uuid)
    {
        $model = $this->findById($uuid);
        return $model->delete();
    }

    public function restore(string $uuid)
    {
        $model = Language::withTrashed()->where('uuid', $uuid)->firstOrFail();
        $model->restore();
        return $model;
    }
}