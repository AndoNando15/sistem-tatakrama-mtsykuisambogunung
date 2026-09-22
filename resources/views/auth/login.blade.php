<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Masuk | Tatakrama MTs YKUI Sambogunung</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-assets/assets/img/favicon.png') }}">

    {{-- Bootstrap & Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/font-awesome.min.css') }}">

    <style>
        * { box-sizing: border-box; }
        body {
            background: linear-gradient(180deg, #1b6e3d 0%, #2d8f4e 100%);
            min-height: 100vh;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Top Header Branding */
        .brand-section {
            padding: 44px 24px 32px;
            text-align: center;
            color: #ffffff;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .brand-logo-circle {
            width: 96px;
            height: 96px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
            border: 3px solid rgba(255, 255, 255, 0.4);
            padding: 8px;
        }
        .brand-logo-circle img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .brand-subtitle {
            font-size: 13px;
            opacity: 0.9;
            font-weight: 400;
            letter-spacing: 0.2px;
        }

        /* Bottom White Sheet Card */
        .login-card-sheet {
            background: #ffffff;
            border-radius: 28px 28px 0 0;
            padding: 36px 28px 40px;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.12);
        }

        @media (min-width: 576px) {
            body { padding: 24px 0; }
            .login-wrapper {
                min-height: auto;
            }
            .login-card-sheet {
                border-radius: 28px;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            }
        }

        .welcome-title {
            font-size: 26px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .welcome-sub {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 26px;
        }

        /* Form Custom Field */
        .custom-label {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            display: block;
        }

        .custom-input-group {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            height: 54px;
            transition: all 0.2s ease;
            margin-bottom: 20px;
        }

        .custom-input-group:focus-within {
            border-color: #1b6e3d;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(27, 110, 61, 0.12);
        }

        .custom-input-icon {
            color: #94a3b8;
            font-size: 18px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .custom-input {
            border: none;
            background: transparent;
            width: 100%;
            height: 100%;
            font-size: 15px;
            color: #1e293b;
            outline: none;
            font-weight: 600;
        }

        .custom-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .custom-checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            accent-color: #1b6e3d;
            cursor: pointer;
        }

        .custom-checkbox-label {
            font-size: 14px;
            color: #475569;
            font-weight: 500;
            cursor: pointer;
            margin: 0;
        }

        .btn-signin {
            width: 100%;
            height: 54px;
            background: linear-gradient(135deg, #1b6e3d 0%, #2d8f4e 100%);
            color: #ffffff;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 8px 20px rgba(27, 110, 61, 0.3);
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn-signin:active {
            transform: scale(0.98);
        }

        .help-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
        }

        .help-link {
            color: #1b6e3d;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">

        {{-- TOP BRANDING --}}
        <div class="brand-section">
            <div class="brand-logo-circle">
                <img src="{{ asset('admin-assets/assets/img/logo.png') }}" alt="Logo MTs YKUI Sambogunung">
            </div>
            <div class="brand-title">TATAKRAMA MTS</div>
            <div class="brand-subtitle">YKUI Sambogunung Dukun Gresik</div>
        </div>

        {{-- BOTTOM LOGIN FORM SHEET --}}
        <div class="login-card-sheet">
            <h2 class="welcome-title">Selamat Datang</h2>
            <p class="welcome-sub">Silakan masukkan username untuk masuk ke sistem</p>

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show small rounded-3 mb-3" role="alert">
                    <i class="fa fa-info-circle me-1"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show small rounded-3 mb-3" role="alert">
                    <i class="fa fa-exclamation-circle me-1"></i> {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="formLogin">
                @csrf

                {{-- USERNAME --}}
                <div class="mb-3">
                    <label for="username" class="custom-label">Username</label>
                    <div class="custom-input-group">
                        <i class="fa fa-user-o custom-input-icon"></i>
                        <input type="text"
                               id="username"
                               name="username"
                               class="custom-input"
                               placeholder="Masukkan username Anda"
                               value="{{ old('username') }}"
                               required
                               autofocus>
                    </div>
                </div>

                {{-- REMEMBER ME --}}
                <div class="custom-checkbox-wrapper">
                    <input type="checkbox"
                           id="remember"
                           name="remember"
                           class="custom-checkbox"
                           {{ old('remember', true) ? 'checked' : '' }}>
                    <label for="remember" class="custom-checkbox-label">Ingat Saya</label>
                </div>

                {{-- SUBMIT BUTTON --}}
                <button type="submit" class="btn-signin" id="btnLogin">
                    Masuk Sistem <i class="fa fa-arrow-right ms-1"></i>
                </button>
            </form>

            {{-- HELP FOOTER --}}
            <div class="help-footer">
                Mengalami kendala saat masuk ke akun?
                <a href="https://wa.me/628123456789" target="_blank" class="help-link">Hubungi Administrator</a>
            </div>
        </div>

    </div>

    {{-- SCRIPTS --}}
    <script src="{{ asset('admin-assets/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin-assets/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $('#formLogin').on('submit', function() {
            $('#btnLogin').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');
        });
    </script>
</body>
</html>
