<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Acquisition;
use Illuminate\Http\Request;
use App\Interfaces\AcquisitionRepositoryInterface;

class AcquisitionController extends Controller
{
    private AcquisitionRepositoryInterface $acquisitionRepo;

    public function __construct(AcquisitionRepositoryInterface $acquisitionRepo)
    {
        $this->acquisitionRepo = $acquisitionRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->all();
        $data = [];
        $columns = [];
        $filter = 'name';

        switch ($request->get('show')) {
            case 'By Branch':
                $filter = 'branch_id';
                $columns = ['branch_id' => 'Cabang', 'data_count' => 'Jumlah'];
                $data = $this->acquisitionRepo->byBranch();
                break;
            case 'By Employee':
                $columns = ['nip' => 'NIP', 'name' => 'Nama', 'data_count' => 'Jumlah'];
                $data = $this->acquisitionRepo->byEmployee();
                break;
            default:
                $columns = [
                    'nip' => 'NIP',
                    'name' => 'Nama',
                    'position' => 'Jabatan',
                    'product' => 'Produk',
                    'branch_id' => 'Cabang',
                    'month' => 'Bulan',
                    'customer' => 'Nasabah',
                    'year' => 'Tahun',
                ];
                $data = $this->acquisitionRepo->index($query);
                break;
        }


        return Inertia::render('acquisition', [
            'filter' => $filter,
            'data' => $data,
            'columnDefinition' => $columns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Acquisition $acquisition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Acquisition $acquisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Acquisition $acquisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Acquisition $acquisition)
    {
        //
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $filepath = fopen($file->getRealPath(), "r");
        $data = [];
        $count = 1;
        while (($getData = fgetcsv($filepath, 1000000, ";")) !== FALSE) {
            if ($count > 1) {
                $data[] = [
                    'nip' => $getData[0],
                    'name' => $getData[1],
                    'position' => $getData[2],
                    'product' => $getData[3],
                    'branch_id' => $getData[4],
                    'month' => $getData[5],
                    'customer' => $getData[6],
                    'year' => 2025,
                ];
            }

            $count++;
        }

        $this->acquisitionRepo->import($data);

        return response()->json([
            // 'data' => $data,
            'message' => $count . ' Data imported successfully',
        ], 200);
    }
}
