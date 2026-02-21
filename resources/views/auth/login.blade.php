<x-guest-layout>
    <style>
        /* Desain Box Login agar lebih modern */
        .login-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
        }
        
        .login-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a202c;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary-custom {
            background-color: #4f46e5 !important;
            width: 100%;
            justify-content: center;
            padding: 12px !important;
            border-radius: 10px !important;
            font-weight: 700 !important;
            transition: 0.3s !important;
        }

        .btn-primary-custom:hover {
            background-color: #4338ca !important;
            transform: translateY(-1px);
        }
    </style>

    <div class="login-card">
        <h2 class="login-title">Selamat Datang Kembali</h2>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" style="border-radius: 10px; border-color: #e2e8f0;" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" style="border-radius: 10px; border-color: #e2e8f0;" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <div class="mt-8">
                <x-primary-button class="btn-primary-custom">
                    {{ __('Masuk Sekarang') }}
                </x-primary-button>
            </div>
            
            <p style="text-align: center; margin-top: 20px; font-size: 0.85rem; color: #64748b;">
                Belum punya akun? <a href="{{ route('register') }}" style="color: #4f46e5; font-weight: 700; text-decoration: none;">Daftar Gratis</a>
            </p>
        </form>
    </div>
</x-guest-layout>