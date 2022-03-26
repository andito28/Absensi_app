<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanHarian;
use DataTables;
use DB;

class LaporanHarianController extends Controller
{
    public function index(){
        return view('laporan-harian.index');
    }

    public function dataLaporanHarian(request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
               $laporanHarian = LaporanHarian::whereBetween(DB::raw('DATE(waktu)'),
                [$request->from_date,$request->to_date])->get();
            }
            else
            {
                $laporanHarian = LaporanHarian::with('User')
                ->orderBy('waktu','DESC')
                ->take(15)
                ->get();
            }
            return Datatables::of($laporanHarian)
                ->addColumn('nama', function ($data) {
                    $nama = $data->User->nama;
                    return $nama;
                })
                ->addColumn('posisi', function ($data) {
                    $posisi = $data->User->posisi;
                    return $posisi;
                })
                ->addColumn('tgl', function ($data) {
                    $tgl = date('d-m-Y', strtotime($data->waktu));
                    return $tgl;
                })
                ->addColumn('jam', function ($data) {
                    $jam = date('h:i:s', strtotime($data->waktu))." WITA";
                    return $jam;
                })
                ->rawColumns(['nama','posisi','jam'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return abort(404);
        }
    }
}
