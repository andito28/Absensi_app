<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use DataTables;

class AbsensiController extends Controller
{
    public function index(){
        return view('absen.index');
    }

    public function dataAbsen(request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
             $dataAbsen = Absen::with('User')
               ->whereBetween('tgl', array($request->from_date, $request->to_date))
               ->get();
            }
            else
            {
                $dataAbsen = Absen::with('User')->orderBy('tgl','DESC')->take(10)->get();
            }
            return Datatables::of($dataAbsen)
                ->addColumn('nama', function ($data) {
                    $nama = $data->User->nama;
                    return $nama;
                })
                ->addColumn('posisi', function ($data) {
                    $posisi = $data->User->posisi;
                    return $posisi;
                })
                ->addColumn('jam_d', function ($data) {
                    return $data->jam_masuk ? $data->jam_masuk.' WITA' : '-';
                })
                ->addColumn('jam_p', function ($data) {
                    return $data->jam_pulang ? $data->jam_pulang.' WITA' : '-';
                })
                ->rawColumns(['nama','posisi','jam_d','jam_p'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return abort(404);
        }
    }
}
