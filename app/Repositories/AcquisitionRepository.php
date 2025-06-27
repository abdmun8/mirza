<?php

namespace App\Repositories;

use App\Models\Acquisition;
use App\Interfaces\AcquisitionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AcquisitionRepository implements AcquisitionRepositoryInterface
{
    public function index($query = array())
    {
        if (isset($query['completed'])) {
            return Acquisition::where('completed', $query['completed'])->get();
        }
        $data = Acquisition::orderBy('name', 'asc')->get();
        return $data;
    }

    public function getById($id)
    {
        return Acquisition::findOrFail($id);
    }

    public function store(array $data)
    {
        return Acquisition::create($data);
    }

    public function update(array $data, $id)
    {
        return Acquisition::whereId($id)->update($data);
    }

    public function delete($id)
    {
        Acquisition::destroy($id);
    }

    public function import($data)
    {
        return Acquisition::insert($data);
    }

    public function byBranch()
    {
        return DB::table('acquisitions')
            ->select(DB::raw('count(branch_id) as data_count, branch_id'))
            ->groupBy('branch_id')
            ->orderBy('data_count', 'desc')
            ->get();
    }

    public function byEmployee()
    {
        return DB::table('acquisitions')
            ->select(DB::raw('count(*) as data_count'), 'name', 'nip')
            ->groupBy('name', 'nip')
            ->orderBy('data_count', 'desc')
            ->get();
    }
}
