<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemagangRequest;
use App\Models\Pemagang;
use App\Models\Presensi;
use App\Models\WaktuKerja;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

class PemagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page');
        $pemagang = Pemagang::all();

        return view('pemagang.index', [
            'data' => $pemagang
        ]);
    }

    public function presensi(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir') ?? date('Y-m-d');
        $tanggal = $request->input('tanggal');
        $nik = $request->input('nik');

        $pemagang = Pemagang::all();
        
        if(Carbon::now()->isDayOfWeek(CarbonInterface::FRIDAY)){
            $payloadWaktuKerja['nama_waktu'] = 'waktu-jumat';
        } else {
            $payloadWaktuKerja['nama_waktu'] = 'waktu-normal';
        }

        $waktuKerja = WaktuKerja::where($payloadWaktuKerja)->first();
        
        $presensi = Presensi::where('is_deleted', '0')
            ->whereHas('profile_pemagang')
            ->with(['profile_pemagang']);

        if ($nik) {
            $presensi = $presensi->where(['nik' => $nik]);
        }

        if(!$tanggalAwal && !$tanggalAkhir){
            $presensi
            ->whereMonth('tanggal', '=', date('m'))
            ->whereYear('tanggal', '=', date('Y'));
        }

        if($tanggal){
            $presensi->whereDate('tanggal', $tanggal);
        }

        if($tanggalAwal && $tanggalAkhir){
            $presensi->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        }

        $presensi->orderBy('tanggal', 'desc');

        if($request->isJson()){
            return response()->json([
                'type' => 'success',
                'data' => $presensi->get()
            ]);
        }

        return view('pemagang.presensi', [
            'pemagang' => $pemagang,
            'presensi' => $presensi->get(),
            'waktuKerja' => $waktuKerja
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return redirect(route('pemagang.index'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PemagangRequest $request)
    {
        $pemagang = new Pemagang();
        $pemagang->nik = $request->nik;
        $pemagang->nama = $request->nama;
        $pemagang->institusi = $request->institusi;
        $pemagang->divisi = $request->divisi;
        $pemagang->save();

        return redirect(route('pemagang.index'))->with([
            'success_message' => 'Data telah tersimpan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemagang $pemagang)
    {
        //
        return redirect(route('pemagang.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemagang $pemagang)
    {
        //
        return view('pemagang.edit', ['pemagang' => $pemagang]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PemagangRequest $request, Pemagang $pemagang)
    {
        $pemagang->nik = $request->nik;
        $pemagang->nama = $request->nama;
        $pemagang->institusi = $request->institusi;
        $pemagang->divisi = $request->divisi;
        $pemagang->save();

        return redirect(route('pemagang.index'))->with([
            'success_message' => 'Data telah tersimpan',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemagang $pemagang)
    {
        //
        $pemagang->delete();

        return redirect(route('pemagang.index'))->with([
            'success_message' => 'Data telah terhapus',
        ]);
    }
}
