<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Peran;
use App\Models\TimKegiatan;
use App\Models\User;
use Illuminate\Http\Request;

class TimKegiatanController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('isAdmin', ['except' => ['index']]);
    // }

    public function index()
    {
        $kegiatan = Kegiatan::whereYear('tgl_mulai', '=', now()->year)
        ->orderBy('tgl_mulai', 'desc')
        ->get(); 
    
        $timkegiatan = TimKegiatan::all();

        return view('timkegiatan.index', [
            'timkegiatan' => $timkegiatan,
            'user' => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
            'kegiatan' => Kegiatan::where('is_deleted', '0')->get(),
            'peran' => Peran::where('is_deleted', '0')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kegiatan' => 'required',
            'id_users' => 'required',
            'id_peran' => 'required',
        ]);
        $array = $request->only([
            'id_kegiatan',
            'id_users',
            'id_peran',

        ]);

        $timkegiatan = TimKegiatan::create($array);

        return redirect()->route('timkegiatan.index')->with('success_message', 'Data telah tersimpan');
    }

    public function update(Request $request, $id_tim)
    {

        $request->validate([
            'id_kegiatan' => 'required',
            'id_users' => 'required',
            'id_peran' => 'required',
        ]);

        $timkegiatan = TimKegiatan::find($id_tim);
        $timkegiatan->id_kegiatan = $request->id_kegiatan;
        $timkegiatan->id_users = $request->id_users;
        $timkegiatan->id_peran = $request->id_peran;
        $timkegiatan->save();

        return redirect()->route('timkegiatan.index')->with('success_message', 'Data telah tersimpan');
    }

    public function destroy(Request $request, $id_tim)
    {

        $timkegiatan = timkegiatan::find($id_tim);
        if ($timkegiatan) {
            $timkegiatan->delete();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus');

    }

    public function laporan(Request $request)
    {

        $pegawai = $request->input('id_users');
        $peran = $request->input('id_peran');
        $tgl_selesai = $request->input('tgl_selesai', date('Y'));

        // Store the selected values in session
        session()->put('selected_id_users', $pegawai);
        session()->put('selected_id_peran', $peran);
        session()->put('selected_tgl_selesai', $tgl_selesai);

        $timkegiatan = TimKegiatan::orderBy('created_at', 'desc');

        if ($pegawai && $peran && $peran != 0) {
            $timkegiatan = TimKegiatan::whereIn('id_users', [$pegawai])
                ->where('id_peran', $peran);

        } elseif ($pegawai) {
            $timkegiatan = TimKegiatan::where('id_users', $pegawai);
        } elseif ($peran) {
            $timkegiatan = TimKegiatan::where('id_peran', $peran);
        }

        $timkegiatan->with(['kegiatan' => function($query) use ($tgl_selesai) {
            return $query->whereYear('tgl_selesai', $tgl_selesai);
        }]);

        $filtered = $timkegiatan->get()->filter(function($item) use ($tgl_selesai){
            if($item?->kegiatan?->tgl_selesai){
                return \Carbon\Carbon::parse($item->kegiatan->tgl_selesai)->format('Y') == $tgl_selesai; 
            }
        });

        $kegiatan = Kegiatan::where('is_deleted', '0');
        $user = User::where('is_deleted', '0')->orderBy('nama_pegawai', 'asc')->whereNot('level', 'admin');
        $peran = Peran::where('is_deleted', '0');

        return view('timkegiatan.laporan', [
            'timkegiatan' => $filtered,
            'user' => $user->get(),
            'peran' => $peran->get(),
            'kegiatan' => $kegiatan->get(),
        ]);
    }
}