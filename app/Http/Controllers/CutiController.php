<?php

namespace App\Http\Controllers;

use App\Exports\CutiExport;
use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CutiController extends Controller
{
    public function export(Request $request)
    {
        $cutis = Cuti::where(['is_deleted' => '0'])->get();

        return Excel::download(new CutiExport($cutis), 'cuti.xlsx');
    }

    public function index()
    {
        $cutis = Cuti::where(['is_deleted' => '0'])->get();
        $users = User::all();

        return view('cuti.index', compact('cutis', 'users'));
    }

    public function create()
    {
        $users = User::all();

        return view('cuti.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_users' => 'required',
            'jatah_cuti' => 'required|integer',
        ]);

        Cuti::create($request->all());

        return redirect()->route('cuti.index')->with('success_message', 'Data telah tersimpan');
    }

    public function edit(Cuti $cuti)
    {
        $users = User::all();

        return view('cuti.edit', compact('cuti', 'users'));
    }

    public function update(Request $request, $id_cuti)
    {
        $validatedData = $request->validate([
            'id_users' => 'required',
            'jatah_cuti' => 'required|integer',
        ]);

        $cuti = Cuti::find($id_cuti);

        $cuti->id_users = $request->id_users;
        $cuti->jatah_cuti = $request->jatah_cuti;

        $cuti->save();

        return redirect()->route('cuti.index')->with('success_message', 'Data telah tersimpan');
    }

    public function destroy($id_cuti)
    {
        $cuti = Cuti::find($id_cuti);
        if ($cuti) {
            $cuti->is_deleted = '1';
            $cuti->save();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus.');
    }
}