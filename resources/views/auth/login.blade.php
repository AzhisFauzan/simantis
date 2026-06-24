<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Login — Sistem Inventaris RS Darmayu</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* Warna Khas RS Darmayu */
            --rs-purple:       #6b21a8;
            --rs-purple-hover: #581c87;
            --rs-green:        #16a34a;
            --rs-green-hover:  #15803d;

            --navy:  #0f172a;
            --navy2: #1e293b;
            --light: #f8fafc;
            --muted: #64748b;
            --white: #ffffff;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
            background: var(--white);
        }

        /* ── WRAPPER ── */
        .login-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* ══════════════════
           LEFT — Form Panel
        ══════════════════ */
        .form-panel {
            width: 38%;
            min-width: 360px;
            max-width: 500px;
            height: 100%;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 52px;
            position: relative;
            z-index: 2;
            box-shadow: 4px 0 32px rgba(15,23,42,.07);
        }

        /* decorative blobs */
        .form-panel::before {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 260px; height: 260px;
            border-radius: 50%;
            /* Ornamen Ungu */
            background: radial-gradient(circle, rgba(107,33,168,.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .form-panel::after {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            /* Ornamen Hijau */
            background: radial-gradient(circle, rgba(22,163,74,.08) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── BRAND LOGO & NAME ── */
        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            opacity: 0;
            animation: fadeUp .6s .05s ease forwards;
            margin-top: -20px;
            margin-bottom: 20px;
        }
        .brand-icon img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            background: var(--white);
            border-radius: 12px;
            padding: 4px;
            box-shadow: 0 6px 20px rgba(107,33,168,.18);
        }
        .brand-name {
            font-family: 'Poppins', 'sans-serif'; /* Ubah ke Montserrat */
            font-size: 3.5rem; /* Perbesar font */
            font-weight: 900; /* Super tebal */
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            line-height: 1;

            /* Efek Text Gradient Ungu-Biru-Hijau */
            background: linear-gradient(90deg, #7c3aed 0%, #3b82f6 50%, #10b981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        .brand-name2 {
            text-align: center;
            font-family: 'Calibri';
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        /* ── FORM BODY ── */
        .form-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ── FIELD ── */
        .field-group {
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeUp .6s ease forwards;
        }
        .field-group:nth-of-type(1) { animation-delay: .32s; }
        .field-group:nth-of-type(2) { animation-delay: .40s; }

        .field-label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: var(--navy2);
            margin-bottom: 8px;
        }

        .field-wrap { position: relative; }

        .field-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            color: #cbd5e1;
            font-size: .9rem;
            pointer-events: none;
            transition: color .2s;
        }

        .form-input {
            width: 100%;
            height: 50px;
            padding: 0 44px 0 44px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: var(--light);
            font-family: 'Poppins', sans-serif;
            font-size: .95rem;
            color: var(--navy);
            outline: none;
            transition: border-color .22s, box-shadow .22s, background .22s;
            -webkit-appearance: none;
        }
        .form-input::placeholder { color: #94a3b8; font-size: .9rem; font-weight: 400; }
        .form-input:focus {
            border-color: var(--rs-purple);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(107,33,168,.08);
        }
        .field-wrap:focus-within .field-icon { color: var(--rs-purple); }

        .toggle-btn {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #cbd5e1;
            cursor: pointer;
            padding: 4px 5px;
            transition: color .2s;
            font-size: .9rem;
            line-height: 1;
        }
        .toggle-btn:hover { color: var(--rs-purple); }

        /* ── SUBMIT ── */
        .btn-submit {
            width: 100%;
            height: 50px;
            margin-top: 12px;
            background: linear-gradient(135deg, var(--rs-green) 0%, var(--rs-green-hover) 100%);
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: .05em;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 6px 20px rgba(22,163,74,.25);
            transition: transform .22s, box-shadow .22s;
            opacity: 0;
            animation: fadeUp .6s .55s ease forwards;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(22,163,74,.35);
        }
        .btn-submit:active { transform: translateY(-1px); }

        /* ── FOOTER ── */
        .form-footer {
            font-size: .8rem;
            color: var(--muted);
            opacity: 0;
            font-weight: 500;
            animation: fadeUp .6s .7s ease forwards;
        }

        /* ══════════════════
           RIGHT — Image Panel
        ══════════════════ */
        .image-panel {
            flex: 1;
            height: 100%;
            overflow: hidden;
            position: relative;
        }
        .image-panel img {
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }
        .image-panel::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(180deg, rgba(107,33,168,0.2) 0%, rgba(15,23,42,0.4) 100%);
            pointer-events: none;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border-left: 4px solid #ef4444;
            animation: fadeUp .6s ease forwards;
        }

        /* ── ANIMATION ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 767px) {
            .image-panel { display: none; }
            .form-panel  { width: 100%; max-width: 100%; min-width: unset; padding: 36px 28px; }
            .brand-name  { font-size: 2.8rem; } /* Pengecilan font di mobile agar tidak pecah */
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="form-panel">

        <div class="brand">
            <div class="brand-icon">
                <img src="/img/logo.png" alt="Logo SIMANTIS">
            </div>
            <div class="brand-name">SIMANTIS</div>

            <div class="brand-name2">Sistem Maintenace dan Inventaris <br> RSU DARMAYU MADIUN</div>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif
        <div class="form-body">
            <form method="post" action="{{ url('login/check') }}">
                @csrf

                <div class="field-group">
                    <label class="field-label" for="form2Example18">Username</label>
                    <div class="field-wrap">
                        <i class="fas fa-user field-icon"></i>
                        <input
                            type="text"
                            name="name"
                            id="form2Example18"
                            class="form-input"
                            placeholder="Masukkan username Anda"
                            autocomplete="username"
                            required
                        />
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="form2Example28">Password</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="form2Example28"
                            class="form-input"
                            placeholder="Masukkan password Anda"
                            autocomplete="current-password"
                            required
                        />
                        <button type="button" class="toggle-btn" id="togglePassword" aria-label="Tampilkan password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Login &nbsp;<i class="fas fa-arrow-right"></i>
                </button>

            </form>
        </div>

        <p class="form-footer">&copy; {{ date('Y') }} RS Darmayu &middot; Sistem Manajemen Inventaris IT</p>
    </div>

    <div class="image-panel d-none d-md-block">
        <img
            src="https://madiun.rsdarmayu.com/wp-content/uploads/2023/11/rs-darmayu-kota-madiun-scaled.jpg"
            alt="RS Darmayu Madiun"
        />
    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordField = document.getElementById("form2Example28");
        var icon = this.querySelector("i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
