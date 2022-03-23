<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('karyawan.index');
    }

    public function dataUser(request $request)
    {
        if ($request->ajax()) {
            $datauser = User::where('role', 'karyawan')->orderBy('posisi','ASC')->get();
            return Datatables::of($datauser)
                ->addColumn('action', function ($data) {
                    $button = "<a href='javascript:void(0)' data-id='$data->id' class='btn btn-success btn-sm edit-user'><i class='mdi mdi-pen'></i></a>";
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button"  id="' . $data->id . '" class="btn btn-danger btn-sm delete-user"><i class="mdi mdi-trash-can"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return abort(404);
        }
    }

    public function store(request $request)
    {

        $id = $request->id;

        $this->validate($request, [
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'posisi' => 'required',
            'hp' => 'required|unique:users,hp,' . $id
        ]);



        $post = User::updateOrCreate(
            ['id' => $request->id],
            [
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'posisi' => $request->posisi,
                'hp' => $request->hp,
                'password' => bcrypt('LinyJaya321'),
                'role' => 'karyawan',
            ]
        );

        return response()->json($post);
    }


    public function edit($id)
    {

        $post = User::findOrFail($id);
        return response()->json($post);
    }


    public function destroy($id)
    {
        $post = User::where('id', $id)->first();
        $post->delete();
        return response()->json($post);
    }
}
