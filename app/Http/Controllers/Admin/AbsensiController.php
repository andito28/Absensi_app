<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\User;
use DataTables;

class AbsensiController extends Controller
{
    public function index(){
        return view('absen.index');
    }

    public function dataAbsen(request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date && $request->nama))
            {
            $nama = $request->nama;
            $dataAbsen = Absen::whereHas(
                'User', function ($query)use ($nama) {
                    $query->where('nama','like',"%".$nama."%");
                }
            )
            ->with('User')
            ->orderBy('tgl','DESC')
            ->whereBetween('tgl', array($request->from_date, $request->to_date))
            ->get();
            }
            elseif(empty($request->name) && !empty($request->from_date)){
                $dataAbsen = Absen::orderBy('tgl','DESC')
                ->whereBetween('tgl', array($request->from_date, $request->to_date))
                ->get();
            }
            else
            {
                $count = User::where('role','karyawan')->count();
                $dataAbsen = Absen::with('User')
                ->orderBy('tgl','DESC')
                ->take($count)
                ->get();
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
                ->addColumn('tgl_a', function ($data) {
                    $tgl = date('d-m-Y', strtotime($data->tgl));
                    return $tgl;
                })
                ->addColumn('jam_d', function ($data) {
                    return $data->jam_masuk ? $data->jam_masuk.' WITA' : '-';
                })
                ->addColumn('jam_p', function ($data) {
                    return $data->jam_pulang ? $data->jam_pulang.' WITA' : '-';
                })
                ->rawColumns(['nama','posisi','tgl_a','jam_d','jam_p'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return abort(404);
        }
    }
}
