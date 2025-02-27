<?php

namespace App\Http\Interfaces;

interface BaseRepositoryInterface
{
    public function index(array $with = [], ?callable $scope = null);
    public function show($id, array $with = []);
    public function store(array $data);
    public function update($id, array $data);
    public function destroy($id);
}
