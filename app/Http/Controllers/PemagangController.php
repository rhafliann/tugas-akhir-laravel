<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemagangRequest;
use App\Models\Pemagang;
use Illuminate\Http\Request;

class PemagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page');
        $pemagang = Pemagang::paginate($page);

        return view('pemagang.index', [
            'data' => $pemagang
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
