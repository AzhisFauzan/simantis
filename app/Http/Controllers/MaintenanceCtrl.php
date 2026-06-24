<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MaintenanceCtrl extends Controller
{
    public function maintenance()
    {
        $maintenances = DB::table('maintenance as a')
        ->leftJoin('kategori_perangkat as b', 'a.id_kategori', '=', 'b.id_kategori')
        ->leftJoin('ruangan as c', 'a.id_ruangan', '=', 'c.id_ruangan')
        ->leftJoin('pengaduan_masuk as d', 'a.id_pengaduan_masuk', '=', 'd.id_pengaduan_masuk')
        ->select(
            'a.*',
            'b.nama_kategori',
            'c.nama_ruangan',
            'd.status as status_pengaduan',
            'd.kategori_perangkat',
        )
        ->get()
        ->groupBy('id_ruangan');

        $kategoriPerangkat = DB::table('kategori_perangkat')->select('id_kategori', 'nama_kategori')->orderBy('nama_kategori')->get()->unique('id_kategori')->groupBy('nama_kategori');

        $ruangan = DB::table('ruangan')->get();

        return view('maintenance.maintenance', compact(
            'maintenances',
            'kategoriPerangkat',
            'ruangan'
        ));
    }

    public function detail_maintenance($id)
    {
        $reference = DB::table('maintenance')
            ->where('id_maintenance', $id)
            ->first();

        if (!$reference) {
            return response()->json([
                'error' => 'Data tidak ditemukan'
            ], 404);
        }

        $maintenances = DB::table('maintenance as m')
            ->leftJoin('ruangan as r', 'r.id_ruangan', '=', 'm.id_ruangan')
            ->leftJoin('kategori_perangkat as k', 'k.id_kategori', '=', 'm.id_kategori')
            ->leftJoin('pengaduan_masuk as pm', 'pm.id_pengaduan_masuk', '=', 'm.id_pengaduan_masuk')
            ->where('m.id_ruangan', $reference->id_ruangan)
            ->whereDate('m.tanggal', \Carbon\Carbon::parse($reference->tanggal)->format('Y-m-d'))
            ->select(
                'm.*',
                'r.nama_ruangan',
                'k.nama_kategori',
                'pm.status as status_pengaduan',
            )
            ->get();

        $first = $maintenances->first();

        $kategori = $maintenances
            ->pluck('nama_kategori')
            ->filter()
            ->unique()
            ->implode(', ');

        $teknisi = $maintenances
            ->pluck('nama_teknisi')
            ->filter()
            ->unique()
            ->implode(', ');

        $deskripsi = $maintenances
        ->map(function ($item) {

            $status = strtolower($item->status_pengaduan ?? '');

            if ($status == 'selesai') {
                $isi = $item->deskripsi ?? '-';

            } elseif ($status == 'diproses') {
                $isi = $item->deskripsi ?? '-';

            } elseif ($status == 'menunggu') {
                $isi = $item->deskripsi ?? '-';
            } elseif ($status == 'diterima') {
                $isi = $item->deskripsi ?? '-';

            } elseif ($status == 'pending' || $status == 'dipending') {
                $isi = $item->deskripsi ?? '-';

            } else {
                $isi = $item->deskripsi ?? '-';
            }

            return '• <b>'.$item->nama_kategori.'</b> : '.$isi;
        })
        ->implode('<br>');

        $uniqueStatuses = $maintenances->pluck('status_pengaduan')->unique()->filter()->values();
        $statusBadgesHtml = '';

        if ($maintenances->whereNotNull('id_pengaduan_masuk')->count() > 0) {
            foreach ($uniqueStatuses as $st) {

                $st = strtolower($st);

                if ($st == 'pending' || $st == 'dipending') {
                    $statusBadgesHtml .= '<span class="badge badge-danger mr-1"><i class="fas fa-clock"></i> Pengaduan Pending</span>';

                } elseif ($st == 'diproses') {
                    $statusBadgesHtml .= '<span class="badge badge-warning mr-1"><i class="fas fa-tools"></i> Pengaduan Diproses</span>';

                } elseif ($st == 'selesai') {
                    $statusBadgesHtml .= '<span class="badge badge-success mr-1"><i class="fas fa-check-circle"></i> Pengaduan Selesai</span>';

                } elseif ($st == 'menunggu') {
                    $statusBadgesHtml .= '<span class="badge badge-secondary mr-1"><i class="fas fa-hourglass-half"></i> Pengaduan Menunggu</span>';
                } elseif ($st == 'diterima') {
                    $statusBadgesHtml .= '<span class="badge badge-primary mr-1"><i class="fas fa-user-check"></i> Pengaduan Diterima</span>';

                } else {
                    $statusBadgesHtml .= '<span class="badge badge-dark mr-1"><i class="fas fa-question-circle"></i> '.$st.'</span>';
                }
            }
        }

        if (empty($statusBadgesHtml)) {
            $statusBadgesHtml = '<span class="badge badge-primary"><i class="fas fa-calendar-check"></i> Jadwal Maintenance</span>';
        }

        return response()->json([
            'nama_ruangan'   => $first->nama_ruangan,
            'tanggal' => \Carbon\Carbon::parse($first->tanggal)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i'),
            'nama_teknisi'   => $teknisi ?: '-',
            'nama_kategori'  => $kategori ?: '-',
            'status_html'    => $statusBadgesHtml,
            'dari_pengaduan' => true,
            'deskripsi'      => $deskripsi ?: '-',
        ]);
    }

    public function kategoriRuangan()
    {
        $data = DB::table('maintenance')->select('id_ruangan', 'id_kategori')->distinct()->get();
        $mapping = [];
        foreach ($data as $row) {
            $mapping[$row->id_ruangan][] = $row->id_kategori;
        }
        return response()->json($mapping);
    }

    public function store_maintenance(Request $request)
    {
        $request->validate([
            'id_kategori'   => 'required|array|min:1',
            'id_ruangan'    => 'required',
            'tanggal'       => 'required',
            'jam'           => 'required',
            'nama_teknisi'  => 'required',
            'deskripsi'     => 'required'
        ]);

        $tanggal = $request->tanggal . ' ' . $request->jam . ':00';

        if (!$request->id_kategori || count($request->id_kategori) == 0) {
            return redirect()->back()->with('error', 'Pilih minimal satu kategori perangkat.');
        }
        if (!$request->id_ruangan) {
            return redirect()->back()->with('error', 'Silakan pilih ruangan.');
        }

        foreach ($request->id_kategori as $id_kategori) {
            DB::table('maintenance')->insert([
                'id_kategori'  => $id_kategori,
                'id_ruangan'   => $request->id_ruangan,
                'tanggal'      => $tanggal,
                'nama_teknisi' => $request->nama_teknisi,
                'deskripsi'    => $request->deskripsi,
            ]);
        }

        return redirect()->back()->with('success', 'Data maintenance berhasil disimpan.');
    }

    public function destroy_maintenance(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) == 0) {
            return response()->json(['message' => 'Tidak ada data dipilih'], 400);
        }

        $deleted = DB::table('maintenance')->whereIn('id_ruangan', $ids)->delete();

        return response()->json([
            'message' => 'Terhapus permanen',
            'count'   => $deleted
        ]);
    }

    public function riwayat_maintenance()
    {
        $maintenances = DB::table('maintenance as a')
            ->join('ruangan as c', 'a.id_ruangan', '=', 'c.id_ruangan')
            ->join('kategori_perangkat as k', 'a.id_kategori', '=', 'k.id_kategori')
            ->leftJoin('pengaduan_masuk as pm', 'a.id_pengaduan_masuk', '=', 'pm.id_pengaduan_masuk')
            ->where(function ($query) {
                $query->where('pm.status', '=', 'Selesai')->orWhereNull('a.id_pengaduan_masuk');
            })
            ->select(
                'a.*',
                'c.nama_ruangan',
                'k.nama_kategori',
                DB::raw('COALESCE(a.deskripsi, "-") as deskripsi')
            )
            ->get();

        $riwayat = $maintenances->groupBy(function ($item) {
            return $item->id_ruangan . '_' . \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
        })->map(function ($group) {
            $first = $group->first();

            $kategori = $group->pluck('nama_kategori')->unique()->implode(', ');
            $id_kategori = $group->pluck('id_kategori')->unique()->implode(',');
            $teknisi = $group->pluck('nama_teknisi')->unique()->filter()->implode(', ');

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
                $isiTeks = $item->deskripsi ?? '-';
                return '• <b>' . $item->nama_kategori . '</b> : ' . $isiTeks;
            })->implode('<br>');

            return (object)[
                'id_maintenance' => $first->id_maintenance,
                'id_ruangan'     => $first->id_ruangan,
                'nama_ruangan'   => $first->nama_ruangan,
                'tanggal'        => $first->tanggal,
                'kategori'       => $kategori,
                'id_kategori'    => $id_kategori,
                'nama_teknisi'   => $teknisi ?: '-',
                'sumber_html'    => $sumber_html,
                'deskripsi'      => $deskripsiGabungan
            ];
        })->values();

        $kategoriPerangkat = DB::table('kategori_perangkat')
            ->orderBy('nama_kategori')
            ->get()
            ->groupBy('nama_kategori');

        return view('maintenance.riwayat_maintenance', compact('riwayat', 'kategoriPerangkat'));
    }

    public function detail_riwayat($id)
    {
        $reference = DB::table('maintenance')->where('id_maintenance', $id)->first();

        if (!$reference) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $maintenances = DB::table('maintenance as m')
            ->leftJoin('ruangan as r', 'r.id_ruangan', '=', 'm.id_ruangan')
            ->leftJoin('kategori_perangkat as k', 'k.id_kategori', '=', 'm.id_kategori')
            ->leftJoin('pengaduan_masuk as pm', 'pm.id_pengaduan_masuk', '=', 'm.id_pengaduan_masuk')
            ->where('m.id_ruangan', $reference->id_ruangan)
            ->whereDate('m.tanggal', \Carbon\Carbon::parse($reference->tanggal)->format('Y-m-d'))
            ->where(function ($query) {
                $query->where('pm.status', '=', 'Selesai')
                      ->orWhereNull('m.id_pengaduan_masuk');
            })
            ->select(
                'm.*',
                'r.nama_ruangan',
                'k.nama_kategori',
                'pm.deskripsi_masalah as deskripsi_pengaduan'
            )
            ->get();

        $first = $maintenances->first();
        $teknisi = $maintenances->pluck('nama_teknisi')->unique()->filter()->implode(', ');

        $deskripsi = $maintenances->map(function ($item) {
            $sumberText = $item->id_pengaduan_masuk
                ? ' <span class="badge badge-info" style="font-size:10px; padding:1px 4px;">Pengaduan</span>'
                : ' <span class="badge badge-secondary" style="font-size:10px; padding:1px 4px;">Manual</span>';

            $isiTeks = $item->id_pengaduan_masuk ? ($item->deskripsi_pengaduan ?? '-') : ($item->deskripsi ?? '-');
            return '• <b>'.$item->nama_kategori.'</b>'.$sumberText.' : '.$isiTeks;
        })->implode('<br>');

        $kategorisFormatted = $maintenances->map(function($item) {
            return ['nama_kategori' => $item->nama_kategori];
        })->unique('nama_kategori')->values()->all();

        return response()->json([
            'nama_ruangan'   => $first->nama_ruangan,
            'tanggal'        => \Carbon\Carbon::parse($first->tanggal)->locale('id')->translatedFormat('d F Y, H:i'),
            'nama_teknisi'   => $teknisi ?: '-',
            'deskripsi'      => $deskripsi ?: '-',
            'kategoris'      => $kategorisFormatted
        ]);
    }

    public function redirectTerimaPengaduan($id)
    {
        $pengaduan = DB::table('pengaduan_masuk')
            ->where('id_pengaduan', $id)
            ->first();

        if (!$pengaduan) {
            return redirect('/maintenance')
                ->with('error', 'Pengaduan tidak ditemukan');
        }

        $maintenance = DB::table('maintenance')
            ->where('id_pengaduan_masuk', $id)
            ->first();

        if (!$maintenance) {
            $maintenanceId = DB::table('maintenance')->insertGetId([
                'id_pengaduan_masuk' => $pengaduan->id_pengaduan_masuk,
                'id_ruangan'         => $pengaduan->id_ruangan,
                'id_kategori'        => $pengaduan->id_kategori,
                'nama_teknisi'       => strtoupper(Auth::user()->name ?? 'Menunggu Teknisi'),
                'tanggal'            => now()->toDateTimeString(),
                'deskripsi'          => null,
                'created_at'         => now()->toDateTimeString(),
                'updated_at'         => now()->toDateTimeString(),
            ]);
        } else {

            DB::table('maintenance')
                ->where('id_maintenance', $maintenance->id_maintenance)
                ->update([
                    'id_pengaduan_masuk' => $pengaduan->id_pengaduan_masuk,
                    'id_ruangan'         => $pengaduan->id_ruangan,
                    'id_kategori'        => $pengaduan->id_kategori,
                    'updated_at'         => now()->toDateTimeString(),
                ]);

            $maintenanceId = $maintenance->id_maintenance;
        }

        DB::table('pengaduan_masuk')
        ->where('id_pengaduan', $id)
        ->update([
            'status' => 'Diterima',
            'updated_at' => now()->toDateTimeString()
        ]);

        DB::table('notifikasi')
            ->where('id_pengaduan', $pengaduan->id_pengaduan)
            ->delete();

        $this->kirimBalikKeSipitrs(
            $pengaduan,
            'Diterima',
            null
        );

        return redirect('/maintenance/maintenance?buka_detail=' . $maintenanceId);
    }

    public function get_latest_maintenance()
    {
        $maintenances = DB::table('maintenance as a')
            ->leftJoin('kategori_perangkat as b', 'a.id_kategori', 'b.id_kategori')
            ->leftJoin('ruangan as c', 'a.id_ruangan', 'c.id_ruangan')
            ->select('a.*', 'c.nama_ruangan')
            ->orderByDesc('a.id_maintenance')
            ->get();

        return response()->json($maintenances);
    }

    public function selesaikanMaintenance(Request $request, $id)
    {
        Log::info('SELESAIKAN MASUK', [
            'id' => $id,
            'data' => $request->all()
        ]);

        $request->validate([
            'status' => 'required|string|in:Pending,Dipending,Diproses,Selesai',
            'deskripsi_tindakan' => 'required_if:status,Selesai|nullable|string|max:500',
            'id_kategori' => 'required|integer'
        ]);

        try {

            $pengaduan = DB::table('pengaduan_masuk')
                ->where('id_pengaduan_masuk', $id)
                ->where('id_kategori', $request->id_kategori)
                ->first();

            if (!$pengaduan) {
                Log::warning('DATA TIDAK COCOK', [
                    'id_pengaduan_masuk' => $id,
                    'id_kategori' => $request->id_kategori
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Kombinasi ID Pengaduan dan Kategori perangkat tidak cocok! Data ditolak.'
                ], 422);
            }

            if ($pengaduan->status === 'Selesai' && $request->status !== 'Selesai') {
                return response()->json([
                    'success' => false,
                    'message' => 'Data sudah Selesai dan tidak bisa diubah lagi'
                ], 400);
            }

            $deskripsi = $request->status === 'Pending' ? null : $request->deskripsi_tindakan;

            DB::table('pengaduan_masuk')
                ->where('id_pengaduan_masuk', $id)
                ->where('id_kategori', $request->id_kategori)
                ->update([
                    'status'     => $request->status,
                    'tanggal' => now()->toDateTimeString(),
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString()
                ]);

            DB::table('maintenance')
                ->where('id_pengaduan_masuk', $id)
                ->where('id_kategori', $request->id_kategori)
                ->update([
                    'deskripsi' => $deskripsi,
                    'tanggal' => now()->toDateTimeString(),
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString()
                ]);

            $this->kirimBalikKeSipitrs($pengaduan, $request->status, $request->deskripsi_tindakan);

            return response()->json([
                'success' => true,
                'message' => 'Maintenance berhasil diupdate menjadi: ' . $request->status
            ]);

        } catch (\Exception $e) {
            Log::error('ERROR SELESAIKAN', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function kirimBalikKeSipitrs($pengaduan, string $status, ?string $deskripsi_tindakan): void
    {
        if (!$pengaduan) return;

        $sipitrUrl = env('SIPITRS_API_URL');
        $sipitrKey = env('SIPITRS_SECRET_KEY');
        $teknisi   = strtoupper(Auth::user()->name ?? '-');

        Log::info('KIRIM KE SIPITRS', [
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'status'       => $status
        ]);

        try {
            $response = Http::withToken($sipitrKey)
                ->timeout(5)
                ->connectTimeout(3)
                ->retry(1, 100)
                ->post($sipitrUrl . '/update-tindakan', [
                    'id_pengaduan'       => $pengaduan->id_pengaduan,
                    'id_pengaduan_masuk' => $pengaduan->id_pengaduan_masuk,
                    'id_ruangan'         => $pengaduan->id_ruangan,
                    'id_perangkat'       => $pengaduan->id_perangkat,
                    'kode_inventaris'    => $pengaduan->kode_inventaris,
                    'kategori_perangkat' => $pengaduan->kategori_perangkat,
                    'merek_perangkat'    => $pengaduan->merek_perangkat,
                    'status'             => $status,
                    'deskripsi_tindakan' => $deskripsi_tindakan,
                    'teknisi'            => $teknisi,
                    'created_at'         => now()->toDateTimeString(),
                    'updated_at'         => now()->toDateTimeString(),
                ]);

            Log::info('RESPON SIPITRS', [
                'http_code' => $response->status(),
                'body'      => $response->body()
            ]);

        } catch (\Exception $e) {
            Log::error('SIPITRS TIMEOUT', [
                'message' => $e->getMessage()
            ]);
        }
    }
}
