<?php

namespace App\Interfaces;

interface AcquisitionRepositoryInterface
{
    public function index(array $query);
    public function getById($id);
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
    public function import(array $data);
    public function byBranch();
    public function byEmployee();
}