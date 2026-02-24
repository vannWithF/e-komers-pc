@extends('layouts.app') {{-- Atau pakai layout kosongan kamu --}}

@section('content')
<div class="auth-page-wrapper">
    <style>
        :root {
            --titanium-orange: #ff6b35;
            --charcoal: #121212;
            --input-bg: #f5f5f7;
            --text-secondary: #86868b;
        }

        /* Full Screen Background */
        .auth-page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f7;
            padding: 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 50px 45px;
            border-radius: 40px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.04);
            border: 1px solid #ffffff;
            max-width: 460px;
            width: 100%;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .login-title {
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--charcoal);
            text-align: center;
            letter-spacing: -2px;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .login-title span {
            color: var(--titanium-orange);
        }

        .login-subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 45px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 0.7rem;
            font-weight: 800;
            color: #aeaeae;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-left: 5px;
            margin-bottom: 8px;
        }

        .titanium-input {
            width: 100%;
            background: var(--input-bg);
            border: 2px solid transparent;
            border-radius: 20px;
            padding: 18px 22px;
            font-weight: 700;
            color: var(--charcoal);
            font-size: 1rem;
            transition: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
        }

        .titanium-input:focus {
            background: white;
            border-color: var(--titanium-orange);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
        }

        /* Error Message Styling */
        .error-msg {
            color: #ff3b30;
            font-size: 0.75rem;
            font-weight: 700;
            margin-top: 8px;
            margin-left: 10px;
            display: block;
        }

        /* Utilities */
        .flex-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 30px;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            accent-color: var(--titanium-orange);
            border-radius: 6px;
            cursor: pointer;
        }

        .remember-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            margin-left: 8px;
        }

        .link-text {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 0.85rem;
            text-decoration: none;
            transition: 0.2s;
        }

        .link-text:hover {
            color: var(--titanium-orange);
        }

        /* Action Button */
        .btn-access {
            width: 100%;
            background: var(--charcoal);
            color: white;
            padding: 22px;
            border-radius: 22px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            margin-top: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-access:hover {
            background: var(--titanium-orange);
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
        }

        .btn-access svg {
            transition: 0.3s;
        }

        .btn-access:hover svg {
            transform: translateX(5px);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            .login-card { padding: 40px 25px; }
            .login-title { font-size: 1.8rem; }
        }
    </style>

    <div class="login-card">
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 60px; height: 60px; background: var(--charcoal); border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 15px 30px rgba(0,0,0,0.1);">
                ⚙️
            </div>
        </div>

        <h2 class="login-title">Warunk<br>PC-Station<span>.</span></h2>
        <p class="login-subtitle">Initialize secure session</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Identity Protocol (Email)</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                       class="titanium-input" required autofocus placeholder="name@domain.com">
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Encryption Key (Password)</label>
                <input id="password" type="password" name="password" 
                       class="titanium-input" required placeholder="••••••••••••">
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex-between">
                <label class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="custom-checkbox">
                    <span class="remember-label">Stay Online</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="link-text" href="{{ route('password.request') }}">
                        Recovery Key?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-access">
                Authorize Access
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
            
            <div style="margin-top: 40px; text-align: center; border-top: 1px solid #f2f2f7; padding-top: 30px;">
                <p style="font-size: 0.85rem; color: var(--text-secondary); font-weight: 600;">
                    No operational ID? <a href="{{ route('register') }}" style="color: var(--titanium-orange); font-weight: 800; text-decoration: none;">Create Identity</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection