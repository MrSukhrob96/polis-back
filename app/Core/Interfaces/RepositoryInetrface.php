<?php

namespace App\Core\Interfaces;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInetrface {
    
    public function create(array $payload): mixed;

    public function delete(Model|int $model): bool;

    public function collection(Builder $query, int|string $limit = 30, array $appends = []): Collection;

    public function getAll();

    public function update(Model|int $model, array $payload): bool;

    public function findById(int $modelId, array $columns = ['*'], array $relations = []): ?Model;

    public function insert(array $data): mixed;

    public function pagination(Builder $query, int $per_page = 30, array $appends = []): LengthAwarePaginator;

    public function updateOrCreate(array $where, array $data);

    public function firstOrCreate(array $where, array $data): mixed;

    public function upsert(array $where, array $data);
}