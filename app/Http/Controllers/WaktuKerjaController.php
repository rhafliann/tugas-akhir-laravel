<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaktuKerjaRequest;
use App\Models\WaktuKerja;
use Illuminate\Http\Request;

class WaktuKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page');
        $data = WaktuKerja::paginate($page);

        return view('waktu-kerja.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return redirect(route('waktu-kerja.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WaktuKerjaRequest $request)
    {
        //
        $waktuKerja = new WaktuKerja();
        $waktuKerja->nama_waktu = $request->nama_waktu;
        $waktuKerja->jam_masuk = $request->jam_masuk;
        $waktuKerja->jam_pulang = $request->jam_pulang;
        $waktuKerja->save();

        return redirect(route('waktu-kerja.index'))->with([
            'success_message' => 'Data telah tersimpan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(WaktuKerja $waktuKerja)
    {
        //
        return redirect(route('waktu-kerja.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WaktuKerja $waktuKerja)
    {
        //
        return view('waktu-kerja.edit', [
            'data' => $waktuKerja
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WaktuKerjaRequest $request, WaktuKerja $waktuKerja)
    {
        //
        $waktuKerja->nama_waktu = $request->nama_waktu;
        $waktuKerja->jam_masuk = $request->jam_masuk;
        $waktuKerja->jam_pulang = $request->jam_pulang;
        $waktuKerja->save();

        return redirect(route('waktu-kerja.index'))->with([
            'success_message' => 'Data telah tersimpan',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WaktuKerja $waktuKerja)
    {
        //
        $waktuKerja->delete();
        return redirect(route('waktu-kerja.index'))->with([
            'success_message' => 'Data telah terhapus',
        ]);
    }
}
