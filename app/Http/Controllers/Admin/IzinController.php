<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Izin;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DataTables;
use Auth;
use DB;


class IzinController extends Controller
{

    public function index()
    {
        return view('izin.index');
    }

    public function dataIzin(request $request)
    {
        if ($request->ajax()) {
            $dataizin = Izin::with('User')->orderBy('status','ASC')->get();
            return Datatables::of($dataizin)
                ->addColumn('nama', function ($data) {
                    $nama = $data->User->nama;
                    return $nama;
                })
                ->addColumn('action', function ($data) {
                    $button = "<a href='javascript:void(0)' data-id='$data->id' class='btn btn-success btn-sm edit-izin'><i class='mdi mdi-pen'></i></a>";
                    return $button;
                })
                ->addColumn('waktu_m', function ($data) {
                    $tgl = date('d-m-Y', strtotime($data->waktu_mulai));
                    return $tgl;
                })
                ->addColumn('waktu_s', function ($data) {
                    $tgl = date('d-m-Y', strtotime($data->waktu_selesai));
                    return $tgl;
                })
                ->addColumn('status_i', function ($data) {
                    if($data->status == 'tolak'){
                        $status = "<span class='badge badge-danger'>$data->status</span>";
                    }else if($data->status == 'terima'){
                        $status = "<span class='badge badge-success'>$data->status</span>";
                    }else{
                        $status = "<span class='badge badge-primary'>$data->status</span>";
                    }

                    return $status;
                })
                ->rawColumns(['action','nama','waktu_m','waktu_s','status_i'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return abort(404);
        }
    }

    public function storeAbsen($request,$post){

    }

    public function store(request $request)
    {

        $id = $request->id;

        $this->validate($request, [
            'user_id' => 'required',
            'jenis_izin' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'ket' => 'required',
            'status' => 'required'
        ]);

        DB::transaction(function () use($request,$id) {

            //update table izin
            $post = Izin::where('id',$id)->first();
            $post->status = $request->status;
            $post->save();

            //update table absen
            $period = CarbonPeriod::create($post->waktu_mulai, $post->waktu_selesai);
                foreach ($period as $date) {
                    $tgl = $date->format('Y-m-d');
                    $data_absen = Absen::where('user_id',$post->user_id)
                    ->where('tgl',$tgl)
                    ->first();
                    if(empty($data_absen) && $post->status == 'terima'){
                        $absen = new Absen();
                        $absen->user_id = $post->user_id;
                        $absen->tgl = $tgl;
                        $absen->jam_masuk = null;
                        $absen->jam_pulang = null;
                        $absen->status = 'IZIN';
                        $absen->koordinat = null;
                        $absen->jenis_absen = null;
                        $absen->save();
                    }else if(!empty($data_absen) && ($request->status == 'tolak' || $request->status == 'proses') ){
                        if($data_absen->status == 'IZIN'){
                            $data_absen->delete();
                        }
                    }else  if(empty($data_absen) && ($request->status == 'tolak' || $request->status == 'proses') ){
                        return response()->json($post);
                    }else{
                        $data_absen->status = "IZIN";
                        $data_absen->save();
                    }
                }

            return response()->json($post);
        });

    }


    public function edit($id)
    {
        $post = Izin::findOrFail($id);
        return response()->json($post);
    }

}
