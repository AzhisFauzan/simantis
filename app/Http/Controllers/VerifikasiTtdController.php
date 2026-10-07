<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class VerifikasiTtdController extends Controller
{
    public function verifikasi(Request $request)
    {
        try {
            $decrypted = Crypt::decryptString($request->query('data', ''));
            $info = json_decode($decrypted, true);

            if (!$info) {
                return view('laporan.verifikasi_ttd', ['error' => true]);
            }

            return view('laporan.verifikasi_ttd', [
                'error'       => false,
                'jenis'       => $info['jenis'] ?? '-',
                'instansi'    => $info['instansi'] ?? 'RSU DARMAYU MADIUN',
                'penandatangan' => $info['penandatangan'] ?? '-',
                'jabatan'     => $info['jabatan'] ?? '-',
                'tanggal_ttd' => $info['tanggal_ttd'] ?? '-',
            ]);
        } catch (\Exception $e) {
            return view('laporan.verifikasi_ttd', ['error' => true]);
        }
    }
}
