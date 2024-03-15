<?php

namespace App\Http\Controllers;

use App\Http\Requests\TandaTangan\CreateTandaTangan;
use App\Http\Requests\TandaTangan\UpdateTandaTangan;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\TandaTangan;
use App\Models\User;

use Carbon\Carbon;

class TandaTanganController extends Controller
{

    private $FILEPATH = "signatures";
    private $PUBLICFILEPATH  = "/storage/signatures";

    public function view($id_users)
    {
        $user = User::where(['id_users' => $id_users])->firstOrFail();
        $tandaTangan = TandaTangan::where(['id_users' => $id_users])->first();
        return view('tanda-tangan.view', [
            'tandaTangan' => $tandaTangan,
            'user' => $user
        ]);
    }

    private function saveImage(FormRequest $request){
        $file = $request->file("image");
        $user = User::where(['id_users' => $request->id_users])->first();
        $filename   = Carbon::now()->format("Ymdhis")."-".$user->nama_pegawai.".". $file->getClientOriginalExtension();
        $storedFile = $file->storeAs($this->FILEPATH, $filename, 'public');
        return [$storedFile, $filename];
    }
    
    public function store(CreateTandaTangan $request)
    {
        [$storedFile, $filename] = $this->saveImage($request);

        if(!$storedFile){
            return response()->json([
                "type" => "error",
                "message" => "Gagal upload tanda tangan"
            ], 400);
        }

        $tandaTangan = TandaTangan::create([
            "image" => $this->PUBLICFILEPATH . '/'. $filename,
            "id_users" => $request->id_users
        ]);

        if($tandaTangan){
            return response()->json([
                "type" => "success",
                "message" => "berhasil menyimpan tanda tangan"
            ], 201);
        }

        return response()->json([
            "type" => "error",
            "message" => "gagal menyimpan tanda tangan"
        ], 400);
    }

    public function update(UpdateTandaTangan $request)
    {
        [$storedFile, $filename] = $this->saveImage($request);

        $tandaTangan = TandaTangan::where([
            'id_users' => $request->id_users
        ])->first();
        
        if(!$storedFile){
            return response()->json([
                "type" => "error",
                "message" => "Gagal upload tanda tangan"
            ], 400);
        }

        if($tandaTangan){
            $tandaTangan->image = $this->PUBLICFILEPATH . '/'. $filename;
            $tandaTangan->save();

            return response()->json([
                "type" => "success",
                "message" => "berhasil menyimpan tanda tangan"
            ], 201);
        }

        return response()->json([
            "type" => "error",
            "message" => "gagal menyimpan tanda tangan"
        ], 400);
    }
}
