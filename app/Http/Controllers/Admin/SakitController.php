<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Sakit;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DataTables;
use Auth;
use DB;


class SakitController extends Controller
{
    public function index()
    {
        return view('sakit.index');
    }

    public function dataSakit(request $request)
    {
        if ($request->ajax()) {
            $datasakit = Sakit::with('User')->orderBy('status','ASC')->get();
            return Datatables::of($datasakit)
                ->addColumn('nama', function ($data) {
                    $nama = $data->User->nama;
                    return $nama;
                })
                ->addColumn('action', function ($data) {
                    $button = "<a href='javascript:void(0)' data-id='$data->id' class='btn btn-success btn-sm edit-sakit'><i class='mdi mdi-pen'></i></a>";
                    return $button;
                })
                ->addColumn('status_s', function ($data) {
                    if($data->status == 'tolak'){
                        $status = "<span class='badge badge-danger'>$data->status</span>";
                    }else if($data->status == 'terima'){
                        $status = "<span class='badge badge-success'>$data->status</span>";
                    }else{
                        $status = "<span class='badge badge-primary'>$data->status</span>";
                    }

                    return $status;
                })
                ->addColumn('waktu_s', function ($data) {
                    $tgl = date('d-m-Y', strtotime($data->waktu));
                    return $tgl;
                })
                ->rawColumns(['action','nama','status_s','waktu_s'])
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
            'waktu' => 'required',
            'ket' => 'required',
            'status' => 'required'
        ]);

        DB::transaction(function () use($request,$id) {

            //update table sakit
            $post = Sakit::where('id',$id)->first();
            $post->status = $request->status;
            $post->save();

            //update table absen
            $data_absen = Absen::where('user_id',$post->user_id)
            ->where('tgl',$post->waktu)
            ->first();

            if(empty($data_absen) && $post->status == 'terima'){
                $absen = new Absen();
                $absen->user_id = $post->user_id;
                $absen->tgl = $post->waktu;
                $absen->jam_masuk = null;
                $absen->jam_pulang = null;
                $absen->status = 'SAKIT';
                $absen->koordinat = null;
                $absen->jenis_absen = null;
                $absen->save();
            }else if(!empty($data_absen) && ($request->status == 'tolak' || $request->status == 'proses') ){
                if($data_absen->status == 'SAKIT'){
                    $data_absen->delete();
                }
            }else if(empty($data_absen) && ($request->status == 'tolak' || $request->status == 'proses') ){
                return response()->json($post);
            }else{
                $data_absen->status = "SAKIT";
                $data_absen->save();
            }

            return response()->json($post);
        });

    }

    public function edit($id)
    {
        $post = sakit::findOrFail($id);
        return response()->json($post);
    }

}
