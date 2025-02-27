<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BaseRepositoryInterface;
use App\Http\Services\Filter\FilterService;
use App\Http\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(array $with = [], ?callable $scope = null)
    {
        $query = $this->model::query();
        if (!empty($with)) {
            $query->with($with);
        }
        if ($scope && is_callable($scope)) {
            $scope($query);
        }
        return $query->simplePaginate(10);
    }

    public function show($id, array $with = [])
    {
        $query = $this->model::query();

        if (!empty($with)) {
            $query->with($with);
        }

        $data = $query->find($id);
        if ($data == null) throw new Exception('No such Record', 404);
        return $data;
    }

    public function store(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        if ($record == null) throw new Exception('No such Record', 404);
        $record->update($data);
        return $record;
    }

    public function destroy($id)
    {
        $record = $this->model::find($id);
        if ($record == null) throw new Exception('No such Record', 404);
        return $record->delete();
    }
}
