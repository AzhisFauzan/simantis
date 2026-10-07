<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LaporanCtrl extends Controller
{
    public function inventaris(Request $request)
    {
        $ruangan = DB::table('ruangan as c')
            ->join('perangkat as a', 'c.id_ruangan', '=', 'a.id_ruangan')
            ->select('c.id_ruangan', 'c.nama_ruangan', DB::raw('COUNT(a.id_perangkat) as jumlah_perangkat'))
            ->groupBy('c.id_ruangan', 'c.nama_ruangan')
            ->having('jumlah_perangkat', '>', 1)
            ->orderBy('c.nama_ruangan')
            ->get();

        $data_perangkat = DB::table('perangkat as a')
            ->join('kategori_perangkat as b', 'a.id_kategori', '=', 'b.id_kategori')
            ->join('ruangan as c', 'a.id_ruangan', '=', 'c.id_ruangan')
            ->leftJoin(DB::raw('(SELECT id_ruangan, MAX(dicetak_pada) as terakhir_cetak FROM riwayat_cetak GROUP BY id_ruangan) as rc'), 'a.id_ruangan', '=', 'rc.id_ruangan')
            ->select('a.*', 'b.nama_kategori', 'c.nama_ruangan', DB::raw('DATE_FORMAT(rc.terakhir_cetak, "%d %M %Y %H:%i") as terakhir_cetak'))
            ->orderBy('a.id_perangkat');

        // whereIn karena checkbox array
        if ($request->filled('id_ruangan')) {
            $data_perangkat->whereIn('a.id_ruangan', (array) $request->id_ruangan);
        }

        $perangkat = $data_perangkat->get();
        return view('laporan.inventaris', compact('perangkat', 'ruangan'));
    }

    public function inventarisPrint(Request $request)
    {
        $data_perangkat = DB::table('perangkat as a')
            ->join('kategori_perangkat as b', 'a.id_kategori', '=', 'b.id_kategori')
            ->join('ruangan as c', 'a.id_ruangan', '=', 'c.id_ruangan')
            ->select('a.*', 'b.nama_kategori', 'c.nama_ruangan')
            ->orderBy('a.id_perangkat');

        if ($request->filled('id_ruangan')) {
            $data_perangkat->whereIn('a.id_ruangan', (array) $request->id_ruangan);
        }

        $perangkat = $data_perangkat->get();

        // Simpan riwayat cetak 1 baris per ruangan yang dipilih
        $ruanganDipilih = $request->filled('id_ruangan') ? (array) $request->id_ruangan : [null];
        foreach ($ruanganDipilih as $idRuangan) {
            DB::table('riwayat_cetak')->insert([
                'id_ruangan'   => $idRuangan ?: null,
                'jenis'        => 'pdf',
                'dicetak_pada' => now(),
            ]);
        }

        // Nama ruangan untuk header PDF
        $namaRuangan = $request->filled('id_ruangan')
            ? DB::table('ruangan')
                ->whereIn('id_ruangan', (array) $request->id_ruangan)
                ->pluck('nama_ruangan')
                ->join(', ')
            : 'Semua Ruangan';

        $qrCodes = $this->generateQrCodes('LAPORAN INVENTARIS PERANGKAT IT');

        $pdf = Pdf::loadView('laporan.inventaris_pdf', compact('perangkat', 'namaRuangan', 'qrCodes'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-inventaris-' . now()->format('Ymd') . '.pdf');
    }

    public function maintenance(Request $request)
    {
        $ruangans = DB::table('ruangan')->orderBy('nama_ruangan')->get();
        $kategoris = DB::table('kategori_perangkat')->orderBy('nama_kategori')->get();

        $query = DB::table('maintenance as m')
            ->leftJoin('kategori_perangkat as k', 'm.id_kategori', '=', 'k.id_kategori')
            ->leftJoin('ruangan as r', 'm.id_ruangan', '=', 'r.id_ruangan')
            ->leftJoin('pengaduan_masuk as pm', function($join) {
                $join->on('m.id_pengaduan_masuk', '=', 'pm.id_pengaduan_masuk')
                     ->on('m.id_kategori', '=', 'pm.id_kategori');
            })
            ->where(function ($q) {
                $q->where('pm.status', '=', 'Selesai')->orWhereNull('m.id_pengaduan_masuk');
            })
            ->select(
                'm.id_maintenance',
                'm.id_ruangan',
                'r.nama_ruangan',
                'm.id_kategori',
                'k.nama_kategori',
                'm.nama_teknisi',
                'm.tanggal',
                'm.deskripsi',
                'm.id_pengaduan_masuk',
                'pm.deskripsi_masalah as deskripsi_pengaduan',
                'pm.created_at as waktu_masuk',
                'm.updated_at as waktu_selesai',
                DB::raw('COALESCE(pm.kode_inventaris, (SELECT MIN(p.kode_inventaris) FROM perangkat p WHERE p.id_ruangan = m.id_ruangan AND p.id_kategori = m.id_kategori)) as kode_inventaris')
            );

        if ($request->filled('id_ruangan')) {
            $query->where('m.id_ruangan', $request->id_ruangan);
        }
        if ($request->filled('id_kategori')) {
            $query->where('m.id_kategori', $request->id_kategori);
        }
        if ($request->filled('dari')) {
            $query->whereDate('m.tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('m.tanggal', '<=', $request->sampai);
        }

        $rawData = $query->orderByDesc('m.tanggal')->get();

        $maintenances = $rawData->groupBy(function ($item) {
            return $item->id_ruangan . '_' . \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
        })->map(function ($group) {
            $first = $group->first();

            $kategori = $group->pluck('nama_kategori')->unique()->implode(', ');
            $id_kategori = $group->pluck('id_kategori')->unique()->implode(',');
            $teknisi = $group->pluck('nama_teknisi')->map(fn($t) => strtoupper($t))->unique()->filter()->implode(', ');
            $kodeInventaris = $group->pluck('kode_inventaris')->unique()->filter()->implode(', ');

            $hasPengaduan = $group->whereNotNull('id_pengaduan_masuk')->count() > 0;
            $hasManual = $group->whereNull('id_pengaduan_masuk')->count() > 0;

            if ($hasPengaduan && $hasManual) {
                $sumber_html = '<span class="badge badge-dark">Campuran</span>';
            } elseif ($hasPengaduan) {
                $sumber_html = '<span class="badge badge-info">Dari Pengaduan</span>';
            } else {
                $sumber_html = '<span class="badge badge-secondary">Input Manual</span>';
            }

            $deskripsiGabungan = $group->map(function ($item) {
                $isiTeks = ($item->deskripsi ?? '-');
                return '• <b>' . $item->nama_kategori . '</b> : ' . $isiTeks;
            })->implode('<br>');

            return (object)[
                'id_maintenance'  => $first->id_maintenance,
                'id_ruangan'      => $first->id_ruangan,
                'nama_ruangan'    => $first->nama_ruangan,
                'tanggal'         => $first->tanggal,
                'waktu_masuk'     => $first->waktu_masuk,
                'waktu_selesai'   => $first->waktu_selesai ?? $first->tanggal,
                'kategori'        => $kategori,
                'id_kategori'     => $id_kategori,
                'nama_teknisi'    => $teknisi ?: '-',
                'sumber_html'     => $sumber_html,
                'deskripsi'       => $deskripsiGabungan,
                'kode_inventaris' => $kodeInventaris ?: '-'
            ];
        })->values();

        return view('laporan.maintenance', compact('maintenances', 'ruangans', 'kategoris'));
    }

    public function printMaintenance(Request $request)
    {
        $query = DB::table('maintenance as m')
        ->leftJoin('kategori_perangkat as k', 'm.id_kategori', '=', 'k.id_kategori')
        ->leftJoin('ruangan as r', 'm.id_ruangan', '=', 'r.id_ruangan')
        ->leftJoin('pengaduan_masuk as pm', function($join) {
            $join->on('m.id_pengaduan_masuk', '=', 'pm.id_pengaduan_masuk')
                 ->on('m.id_kategori', '=', 'pm.id_kategori');
        })
        ->where(function ($q) {
            $q->where('pm.status', '=', 'Selesai')->orWhereNull('m.id_pengaduan_masuk');
        })
        ->select(
            'm.id_maintenance',
            'm.id_ruangan',
            'r.nama_ruangan',
            'm.id_kategori',
            'k.nama_kategori',
            'm.nama_teknisi',
            'm.tanggal',
            'm.deskripsi',
            'm.id_pengaduan_masuk',
            'pm.deskripsi_masalah as deskripsi_pengaduan',
            'pm.created_at as waktu_masuk',
            'm.updated_at as waktu_selesai',
            DB::raw('COALESCE(pm.kode_inventaris, (SELECT MIN(p.kode_inventaris) FROM perangkat p WHERE p.id_ruangan = m.id_ruangan AND p.id_kategori = m.id_kategori)) as kode_inventaris')
        );

        if ($request->filled('id_ruangan')) {
            $query->where('m.id_ruangan', $request->id_ruangan);
        }
        if ($request->filled('id_kategori')) {
            $query->where('m.id_kategori', $request->id_kategori);
        }
        if ($request->filled('dari')) {
            $query->whereDate('m.tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('m.tanggal', '<=', $request->sampai);
        }

        $rawData = $query->orderByDesc('m.tanggal')->get();

        $maintenances = $rawData->groupBy(function ($item) {
            return $item->id_ruangan . '_' . \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
        })->map(function ($group) {

            $first = $group->first();

            $kategori = $group->pluck('nama_kategori')->unique()->implode(', ');
            $id_kategori = $group->pluck('id_kategori')->unique()->implode(',');
            $teknisi = $group->pluck('nama_teknisi')->map(fn($t) => strtoupper($t))->unique()->filter()->implode(', ');
            $kodeInventaris = $group->pluck('kode_inventaris')->unique()->filter()->implode(', ');

            $hasPengaduan = $group->whereNotNull('id_pengaduan_masuk')->count() > 0;
            $hasManual = $group->whereNull('id_pengaduan_masuk')->count() > 0;

            if ($hasPengaduan && $hasManual) {
                $sumber_html = '<span class="badge badge-dark" style="background-color: #343a40; color: white; padding: 3px 6px; border-radius: 4px;">Campuran</span>';
            } elseif ($hasPengaduan) {
                $sumber_html = '<span class="badge badge-info" style="background-color: #17a2b8; color: white; padding: 3px 6px; border-radius: 4px;">Dari Pengaduan</span>';
            } else {
                $sumber_html = '<span class="badge badge-secondary" style="background-color: #6c757d; color: white; padding: 3px 6px; border-radius: 4px;">Input Manual</span>';
            }

            $deskripsiGabungan = $group->unique('id_kategori')->map(function ($item) {

                $kategori = trim($item->nama_kategori ?? '');
                $rawDeskripsi = trim($item->deskripsi ?? '');

                $parts = explode('|', $rawDeskripsi);
                $isiArray = [];

                foreach ($parts as $part) {

                    $part = trim($part);

                    if ($kategori !== '' && preg_match('/^' . preg_quote($kategori, '/') . '\s*:/i', $part)) {

                        $isi_text = trim(
                            preg_replace(
                                '/^' . preg_quote($kategori, '/') . '\s*:\s*/i',
                                '',
                                $part
                            )
                        );

                        if ($isi_text !== '') {
                            $isiArray[] = $isi_text;
                        }
                    }
                }

                if (empty($isiArray) && $rawDeskripsi !== '') {

                    $isi_text = trim(
                        preg_replace(
                            '/^' . preg_quote($kategori, '/') . '\s*:\s*/i',
                            '',
                            $rawDeskripsi
                        )
                    );

                    if ($isi_text !== '') {
                        $isiArray[] = $isi_text;
                    }
                }

                $isi = empty($isiArray)
                    ? '-'
                    : implode(', ', array_unique($isiArray));

                return '• <b>' . $kategori . '</b> : ' . $isi;

            })->filter()->unique()->implode('<br>');

            return (object)[
                'id_maintenance'  => $first->id_maintenance,
                'id_ruangan'      => $first->id_ruangan,
                'nama_ruangan'    => $first->nama_ruangan,
                'tanggal'         => $first->tanggal,
                'waktu_masuk'     => $first->waktu_masuk,
                'waktu_selesai'   => $first->waktu_selesai ?? $first->tanggal,
                'kategori'        => $kategori,
                'id_kategori'     => $id_kategori,
                'nama_teknisi'    => $teknisi ?: '-',
                'sumber_html'     => $sumber_html,
                'deskripsi'       => $deskripsiGabungan,
                'kode_inventaris' => $kodeInventaris ?: '-'
            ];
        })->values();

        $qrCodes = $this->generateQrCodes('LAPORAN RIWAYAT MAINTENANCE IT');

        $pdf = Pdf::loadView('laporan.maintenance_pdf', compact('maintenances', 'qrCodes'))->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-maintenance-' . now()->format('Ymd') . '.pdf');
    }

    private function generateQrCodes(string $jenisLaporan): array
    {
        $tanggalTtd = now()->format('d-m-Y H:i:s');
        $baseUrl = url('/verifikasi-ttd');

        $signers = [
            'teknisi' => [
                'jenis'         => $jenisLaporan,
                'instansi'      => 'RSU DARMAYU MADIUN',
                'penandatangan' => 'ALLYSA JUNE ARRAHMAN, S.Kom.',
                'jabatan'       => 'TEKNISI',
                'tanggal_ttd'   => $tanggalTtd,
            ],
            'kepala' => [
                'jenis'         => $jenisLaporan,
                'instansi'      => 'RSU DARMAYU MADIUN',
                'penandatangan' => 'INDRA LAKSANA PUTRA, S.Kom.',
                'jabatan'       => 'KEPALA UNIT IT / PROGRAMMER',
                'tanggal_ttd'   => $tanggalTtd,
            ],
        ];

        $qrCodes = [];
        foreach ($signers as $key => $data) {
            $encrypted = Crypt::encryptString(json_encode($data));
            $url = $baseUrl . '?data=' . urlencode($encrypted);

            $svg = QrCode::format('svg')
                    ->size(120)
                    ->margin(1)
                    ->generate($url);

            $qrCodes[$key] = base64_encode($svg);
        }

        return $qrCodes;
    }
}

