<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tanda Tangan Elektronik</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 420px;
            width: 100%;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 24px 20px;
            text-align: center;
            color: #ffffff;
        }
        .card-header .icon-container {
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        .card-header .icon-container i {
            font-size: 40px;
            color: #22c55e;
        }
        .card-header .icon-container.error i {
            color: #ef4444;
        }
        .card-header h1 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .card-header p {
            font-size: 13px;
            font-weight: 500;
            opacity: 0.9;
        }
        .card-body {
            padding: 24px;
        }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }
        .info-row {
            margin-bottom: 16px;
        }
        .info-row .label {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .info-row .value {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            background: #f3f4f6;
            padding: 10px 14px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .digital-notice {
            text-align: center;
            margin-top: 20px;
            padding: 12px 16px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 10px;
        }
        .digital-notice i {
            color: #22c55e;
            margin-right: 6px;
        }
        .digital-notice span {
            font-size: 12px;
            font-weight: 600;
            color: #065f46;
        }
        .card-footer {
            padding: 0 24px 24px;
            text-align: center;
        }
        .btn-kembali {
            display: inline-block;
            width: 100%;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .btn-kembali:hover {
            opacity: 0.9;
        }
        .error-msg {
            padding: 24px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        @if($error)
            <div class="card-header">
                <div class="icon-container error">
                    <i class="fas fa-times"></i>
                </div>
                <h1>VERIFIKASI GAGAL</h1>
                <p>Data tidak valid atau telah kedaluwarsa</p>
            </div>
            <div class="error-msg">
                <p>QR Code yang Anda pindai tidak dapat diverifikasi. Pastikan dokumen yang Anda miliki adalah dokumen asli dari RSU Darmayu Madiun.</p>
            </div>
        @else
            <div class="card-header">
                <div class="icon-container">
                    <i class="fas fa-check"></i>
                </div>
                <h1>{{ $jenis }}</h1>
                <p>Verifikasi Dokumen</p>
            </div>
            <div class="card-body">
                <div class="section-title">
                    <i class="fas fa-info-circle" style="color: #667eea; margin-right: 4px;"></i>
                    Informasi Penandatanganan
                </div>

                <div class="info-row">
                    <div class="label">Instansi</div>
                    <div class="value">{{ $instansi }}</div>
                </div>

                <div class="info-row">
                    <div class="label">Penandatangan</div>
                    <div class="value">{{ $penandatangan }}</div>
                </div>

                <div class="info-row">
                    <div class="label">Jabatan</div>
                    <div class="value">{{ $jabatan }}</div>
                </div>

                <div class="info-row">
                    <div class="label">Tgl. Penandatanganan</div>
                    <div class="value">{{ $tanggal_ttd }}</div>
                </div>

                <div class="info-row">
                    <div class="label">Tanggal Pindai</div>
                    <div class="value" id="tanggalPindai">-</div>
                </div>

                <div class="digital-notice">
                    <i class="fas fa-shield-alt"></i>
                    <span>Dokumen ini telah ditandatangani secara elektronik</span>
                </div>
            </div>
        @endif
        <div class="card-footer">
            <a href="javascript:history.back()" class="btn-kembali">Kembali</a>
        </div>
    </div>

    <script>
        // Isi tanggal pindai secara otomatis
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('tanggalPindai');
            if (el) {
                var now = new Date();
                var options = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
                el.textContent = now.toLocaleString('id-ID', options).replace(/\./g, ':');
            }
        });
    </script>
</body>
</html>
