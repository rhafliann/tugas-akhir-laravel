<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Url;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\QrCodeInterface;
use Endroid\QrCode\Writer\Result\GdResult;
use Endroid\QrCode\Writer\Result\PngResult;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Endroid\QrCode\Matrix\MatrixInterface;
use Endroid\QrCode\Writer\WriterInterface;
use Illuminate\Support\Facades\URL as FacadesURL;

class UrlController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $url = Url::whereYear('created_at', $tahun);
        
        $kegiatan = Kegiatan::where(['is_deleted' => '0'])
        ->whereYear('tgl_mulai', $tahun)
        ->orWhereYear('tgl_selesai', $tahun)
        ->get();

        return view('url.index', [
            'url' => $url->get(),
            'kegiatan' => $kegiatan,
            'user' => User::where('is_deleted', '0')->get(),
            'tahun' => $tahun
        ]);
    }

    public function store(Request $request)
    {
        //Menyimpan Data Kegiatan
        $request->validate([
            'id_users' => 'required',
            'url_address' => 'nullable|url',
            'nama_kegiatan' => 'required',
            'jenis' => 'required',
            'url_short' => 'required',
        ]);

        $existingUrl = Url::where('url_short', $request->url_short)->first();

        if ($existingUrl != null) {
            return redirect()->back()->with('error_message', 'URL pendek sudah ada dalam basis data.');
        }

        $url = new Url();
        $url->id_users = $request->id_users;
        $url->url_address = $request->url_address;
        $url->jenis = $request->jenis;
        $url->nama_kegiatan = $request->nama_kegiatan;
        $customCode = $request->url_short;

        $slug = Str::slug($customCode, '-');
        $short = $this->generateShortCode($slug);
        $url->url_short = $short;
        $qrcode = $this->generateQRCode($url->url_short, $short);
        $url->qrcode_image = $qrcode;

        $url->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    private function generateShortCode($slug)
    {
        $existingUrl = Url::where('url_short', $slug)->first();

        if ($existingUrl) {
            return redirect()->back()->with('error_message', 'URL pendek sudah ada dalam basis data.');
        }

        $code = $slug;

        // Check if the generated code already exists in the database
        $exists = Url::where('url_short', $code)->exists();

        // If the code exists, generate a new one until it's unique
        while ($exists) {
            $code = $slug; // Generate a new code
            $exists = Url::where('url_short', $code)->exists();
        }

        return $code;
    }

    public function redirect($shortUrl)
    {
        // Look up the short URL in the database
        $urlRecord = Url::where('url_short', "https://s.qiteplanguage.org/" . $shortUrl)->first();

        // Check if the short URL exists in the database
        if ($urlRecord) {
            // Redirect to the original URL
            return redirect()->away($urlRecord->url_address);
        } else {
            // Handle the case where the short URL does not exist
            return redirect()->back()->with('error_message', 'Tidak Ditemukan Url.');
        }
    }

    private function generateQRCode($url, $imageName)
    {
        if (is_null($imageName)) {
            $imageName = uniqid('qrcode_');
        }

        $qrCode = QrCode::create($url)->setSize(200)->setMargin(10)->setErrorCorrectionLevel(new ErrorCorrectionLevelLow());

        // Create a PngWriter instance
        $writer = new PngWriter();

        $qrCodeData = $writer->write($qrCode)->getString();

        Storage::disk('public')->put('qrcodes/'. $imageName . '.png', $qrCodeData, 'public');

        // Return the filename (including the extension) for further use if needed
        return $imageName . '.png';
    }





    public function update(Request $request, $id_url)
    {
        $request->validate([
            'id_users' => 'required',
            'url_address' => 'required|url',
            'nama_kegiatansl => required',
            'jenis' => 'required',
            'url_short' => 'required',
        ]);

        $url = Url::find($id_url);
        $url->id_users = $request->id_users;
        $url->url_address = $request->url_address;
        $url->jenis = $request->jenis;

        if (! empty($url->qrcode_image)) {
            $url->qrcode_image = null;
        }

        $lasUrl = Url::where('id_url', $id_url)->get()[0];

        if($lasUrl->url_short !== $request->url_short){
            $customCode = $request->input('url_short');
            $slug = Str::slug($customCode, '-');
            $short = $this->generateShortCode( $slug);
            $url->url_short = $short;
        }

        $qrcode = $this->generateQRCode($url->url_short, $short);
        $url->qrcode_image = $qrcode;

        $url->save();

        return redirect()->back()->with('success_message', 'Data telah tersimpan');
    }

    public function destroy($id_url)
    {
        $url = Url::find($id_url);
        if ($url) {
            if ($url->qrcode_image) {
                Storage::disk('public')->delete('qrcodes/'.$url->qrcode_image);
            }
            $url->delete();
        }

        return redirect()->back()->with('success_message', 'Data telah tersimpan.');
    }
}