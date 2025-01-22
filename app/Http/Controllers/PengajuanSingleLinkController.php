<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\PengajuanSingleLink;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Str;

class PengajuanSingleLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $tahun = $request->input('tahun', date('Y'));

        $ajuansinglelink = PengajuanSingleLink::where('is_deleted', '0')
        ->whereYear('tgl_pengajuan', $tahun)
        ->orderByDesc('id_pengajuan_singlelink')->get();
        
        $kegiatan = Kegiatan::where(['is_deleted' => '0'])
        ->whereYear('tgl_mulai', $tahun)
        ->orWhereYear('tgl_selesai', $tahun)
        ->get();

        return view('ajuansinglelink.index', [
            'ajuansinglelink' => $ajuansinglelink,
            'kegiatan' => $kegiatan,
            'users' => User::where('is_deleted', '0')->orderByRaw("LOWER(nama_pegawai)")->get(),
            'tahun' => $tahun
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_users'=> 'required',
            'nama_kegiatan'=> 'required',
            'nama_shortlink'=> 'required',
            'keterangan_pemohon'=> 'required',
        ]);
    

        $ajuansinglelink = new PengajuanSingleLink();
    
            $ajuansinglelink->id_users = $request->id_users;
            $ajuansinglelink->nama_kegiatan = $request->nama_kegiatan;
            $ajuansinglelink->nama_shortlink = $request->nama_shortlink;
            $ajuansinglelink->keterangan_pemohon = $request->keterangan_pemohon;
            $ajuansinglelink->save();

            $pengguna = User::where('id_users', $request->id_users)->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link';
            $notifikasi->pesan = 'Pengajuan Single link anda sudah berhasil dikirimkan. Kami telah mengirimkan notifikasi untuk memproses pengajuanmu.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'no';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuansinglelink';
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();

            $notifikasiKadiv = User::where('id_jabatan', '8')->get();
            foreach($notifikasiKadiv as $nk){
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link';
            $notifikasi->pesan =  'Pengajuan Single Link dari '.$pengguna->nama_pegawai.'. Dimohon untuk segara menyiapkan single link.'; 
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuansinglelink';
            $notifikasi->send_email = 'yes';
            $notifikasi->id_users = $nk->id_users;
            $notifikasi->save();
            }
    
    
            $notifikasiAdmin = User::where('level', 'admin')->get();
            foreach($notifikasiAdmin as $na){
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link';
            $notifikasi->pesan = 'Pengajuan Single Link dari '.$pengguna->nama_pegawai.'. Mohon berikan persetujan kepada pemohon.'; // Sesuaikan pesan notifikasi sesuai kebutuhan Anda.
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->send_email = 'no';
            $notifikasi->label = 'info';
            $notifikasi->link = '/ajuansinglelink';
            $notifikasi->id_users = $na->id_users;
            $notifikasi->save();
            }
    
            return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id_pengajuan_singlelink)
    {
        $ajuansinglelink = PengajuanSingleLink::findOrFail($id_pengajuan_singlelink);
        $users = User::where('is_deleted', '0')->get();

        return view('ajuansinglelink.show', [
            'ajuansinglelink' => $ajuansinglelink,
            'users' => $users,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanSingleLink $pengajuanSingleLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id_pengajuan_singlelink)
    {
        if(auth()->user()->level == 'admin' ) {
        $request->validate([
            'nama_kegiatan'=> 'required',
            'nama_shortlink'=> 'required',
            'keterangan_pemohon'=> 'required',
            'keterangan_operator'=> 'required',
            'status'=> 'required',
        ]);

        $ajuansinglelink = PengajuanSingleLink::find($id_pengajuan_singlelink);

        $ajuansinglelink->nama_kegiatan = $request->nama_kegiatan;
        $ajuansinglelink->nama_shortlink =  $request->nama_shortlink;
        $ajuansinglelink->keterangan_pemohon = $request->keterangan_pemohon;
        $ajuansinglelink->keterangan_operator = $request->keterangan_operator;
        $ajuansinglelink->status =  $request->status;
        $ajuansinglelink->save();

        if($ajuansinglelink->status == 'ready'){
            $pengguna = User::where('id_users', $ajuansinglelink->id_users)->first();
            $notifikasi = new Notifikasi();
            $notifikasi->judul = 'Pengajuan Single Link';
            $notifikasi->pesan = 'Pengajuan Single Link anda sudah dibuat. Silahkan cek detail pengajuan single link anda.';
            $notifikasi->is_dibaca = 'tidak_dibaca';
            $notifikasi->label = 'info';
            $notifikasi->send_email = 'yes';
            $notifikasi->link = '/ajuansinglelink';  
            $notifikasi->id_users = $pengguna->id_users;
            $notifikasi->save();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');

        } else {
            $request->validate([
                'nama_kegiatan'=> 'required',
                'nama_shortlink'=> 'required',
                'keterangan_pemohon'=> 'required',
            ]);
    
            $ajuansinglelink = PengajuanSingleLink::find($id_pengajuan_singlelink);

            $ajuansinglelink->nama_kegiatan = $request->nama_kegiatan;
            $ajuansinglelink->nama_shortlink = $request->nama_shortlink;
            $ajuansinglelink->keterangan_pemohon = $request->keterangan_pemohon;
            $ajuansinglelink->save();

            if($ajuansinglelink->status == 'ready'){
                $pengguna = User::where('id_users', $ajuansinglelink->id_users)->first();
                $notifikasi = new Notifikasi();
                $notifikasi->judul = 'Pengajuan Single Link';
                $notifikasi->pesan = 'Pengajuan Single Link anda sudah dibuat. Silahkan cek detail pengajuan single link anda.';
                $notifikasi->is_dibaca = 'tidak_dibaca';
                $notifikasi->label = 'info';
                $notifikasi->send_email = 'yes';
                $notifikasi->link = '/ajuansinglelink';  
                $notifikasi->id_users = $pengguna->id_users;
                $notifikasi->save();
            }
    
            return redirect()->back()->with('success_message', 'Data telah tersimpan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pengajuan_singlelink)
    {
        $ajuansinglelink = PengajuanSingleLink::find($id_pengajuan_singlelink);
        if ($ajuansinglelink) {
            $ajuansinglelink->is_deleted = '1';
            $ajuansinglelink->save();
        }

        return redirect()->back()->with('success_message', 'Data telah terhapus.');
    }
}
