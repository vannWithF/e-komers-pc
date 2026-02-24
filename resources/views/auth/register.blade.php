@extends('layouts.app')

@section('content')
<div class="auth-page-wrapper">
    <style>
        :root {
            --titanium-orange: #ff6b35;
            --charcoal: #121212;
            --input-bg: #f5f5f7;
            --text-secondary: #86868b;
        }

        .auth-page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f7;
            padding: 40px 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 50px 45px;
            border-radius: 40px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.04);
            border: 1px solid #ffffff;
            max-width: 500px;
            width: 100%;
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .register-title {
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--charcoal);
            text-align: center;
            letter-spacing: -2px;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .register-title span {
            color: var(--titanium-orange);
        }

        .register-subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 40px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
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
            border-radius: 18px;
            padding: 16px 22px;
            font-weight: 700;
            color: var(--charcoal);
            font-size: 0.95rem;
            transition: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
            box-sizing: border-box;
        }

        .titanium-input:focus {
            background: white;
            border-color: var(--titanium-orange);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
        }

        /* Password Grid */
        .password-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .error-msg {
            color: #ff3b30;
            font-size: 0.7rem;
            font-weight: 700;
            margin-top: 6px;
            margin-left: 10px;
            display: block;
        }

        /* Action Button */
        .btn-register {
            width: 100%;
            background: var(--charcoal);
            color: white;
            padding: 20px;
            border-radius: 20px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-register:hover {
            background: var(--titanium-orange);
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.3);
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #f2f2f7;
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-decoration: none;
        }

        .login-link b {
            color: var(--titanium-orange);
            font-weight: 800;
            transition: 0.2s;
        }

        .login-link:hover b {
            letter-spacing: 0.5px;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .password-row { grid-template-columns: 1fr; }
            .register-card { padding: 40px 25px; }
        }
    </style>

    <div class="register-card">
        <div style="text-align: center; margin-bottom: 25px;">
            <div style="width: 60px; height: 60px; background: var(--titanium-orange); color: white; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 15px 30px rgba(255, 107, 53, 0.2);">
                👤
            </div>
        </div>

        <h2 class="register-title">Join the<br>Station<span>.</span></h2>
        <p class="register-subtitle">Create your operative account</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Designation (Name)</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" 
                       class="titanium-input" required autofocus placeholder="Your full name">
                @error('name')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Communication Link (Email)</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" 
                       class="titanium-input" required placeholder="name@domain.com">
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="password-row">
                <div class="form-group">
                    <label for="password">Security Key</label>
                    <input id="password" type="password" name="password" 
                           class="titanium-input" required placeholder="Min 8 chars">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Verify Key</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                           class="titanium-input" required placeholder="Repeat key">
                </div>
            </div>
            
            @error('password')
                <span class="error-msg" style="margin-top: -10px; margin-bottom: 15px;">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn-register">
                Establish Identity
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </button>
            
            <a href="{{ route('login') }}" class="login-link">
                Already part of the station? <b>Login Access</b>
            </a>
        </form>
    </div>
</div>
@endsection