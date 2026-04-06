@extends('layouts.app')

@section('content')
<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-orange: #e85a24;
        --charcoal-bg: #0f1012;
        --glass-surface: rgba(255, 255, 255, 0.8);
        --glass-border: rgba(255, 255, 255, 0.5);
        --input-fill: #f2f2f7;
    }

    .profile-container {
        max-width: 1200px;
        margin: 40px auto 80px;
        padding: 0 30px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 1. ANIMATED HEADER */
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .settings-header {
        margin-bottom: 50px;
        animation: slideDown 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .settings-header .tag {
        color: var(--titanium-orange);
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 8px;
    }

    .settings-header h1 {
        font-size: 3.5rem;
        font-weight: 900;
        letter-spacing: -3px;
        color: #1d1d1f;
        margin: 0;
        line-height: 1;
    }

    /* 2. LAYOUT GRID */
    .settings-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 40px;
        align-items: start;
    }

    /* 3. AVATAR CARD - GLASS */
    .avatar-glass-card {
        background: var(--glass-surface);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 40px;
        padding: 50px 40px;
        text-align: center;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        position: sticky;
        top: 120px;
        transition: transform 0.4s ease;
    }

    .avatar-glass-card:hover { transform: translateY(-5px); }

    .squircle-wrapper {
        position: relative;
        width: 160px;
        height: 160px;
        margin: 0 auto 25px;
    }

    .squircle-img {
        width: 100%;
        height: 100%;
        border-radius: 54px; /* Classic Squircle Ratio */
        object-fit: cover;
        box-shadow: 0 15px 35px rgba(255, 107, 53, 0.2);
        border: 4px solid white;
    }

    .status-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        padding: 6px 14px;
        background: var(--titanium-orange);
        color: white;
        font-size: 0.65rem;
        font-weight: 800;
        border-radius: 100px;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* 4. SETTINGS FORM - MODULES */
    .forms-stack {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .module-card {
        background: white;
        border-radius: 40px;
        padding: 50px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        border: 1px solid #f1f1f5;
        animation: fadeIn 1s ease;
    }

    .module-title {
        font-size: 1.5rem;
        font-weight: 900;
        letter-spacing: -1px;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .module-title i {
        width: 38px; height: 38px;
        background: var(--soft-orange);
        color: var(--titanium-orange);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-style: normal;
        font-size: 1.1rem;
    }

    /* FORM ELEMENTS */
    .field-group { margin-bottom: 25px; }
    .field-group label {
        display: block;
        font-size: 0.75rem;
        font-weight: 800;
        color: #86868b;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 12px;
    }

    .input-premium {
        width: 100%;
        background: var(--input-fill);
        border: 2px solid transparent;
        padding: 18px 24px;
        border-radius: 18px;
        font-size: 1rem;
        font-weight: 700;
        color: #1d1d1f;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-premium:focus {
        background: white;
        border-color: var(--titanium-orange);
        box-shadow: 0 10px 30px rgba(255, 107, 53, 0.08);
        outline: none;
    }

    .file-input-wrapper {
        position: relative;
        background: #fdf2ee;
        border: 2px dashed #ff6b3533;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        transition: 0.3s;
    }

    .file-input-wrapper:hover { border-color: var(--titanium-orange); }

    .btn-action {
        width: 100%;
        padding: 20px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 800;
        border: none;
        cursor: pointer;
        transition: all 0.4s;
    }

    .btn-primary {
        background: #1d1d1f;
        color: white;
    }

    .btn-primary:hover {
        background: var(--titanium-orange);
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(255, 107, 53, 0.3);
    }

    .btn-secondary {
        background: #f2f2f7;
        color: #1d1d1f;
        margin-top: 15px;
    }

    .btn-secondary:hover { background: #e5e5ea; }

    @media (max-width: 1024px) {
        .settings-grid { grid-template-columns: 1fr; }
        .avatar-glass-card { position: relative; top: 0; }
        .settings-header h1 { font-size: 2.8rem; }
    }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="profile-container">
    <header class="settings-header">
        <span class="tag">Security & Identity</span>
        <h1>Account <span>Settings.</span></h1>
    </header>

    @if(session('success'))
        <div style="background: #e8f5e9; color: #2e7d32; padding: 20px 30px; border-radius: 24px; font-weight: 800; margin-bottom: 40px; border-left: 6px solid #4caf50;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="settings-grid">
        <!-- Sidebar Branding & Avatar -->
        <aside>
            <div class="avatar-glass-card">
                <div class="squircle-wrapper">
                    <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=ff6b35&color=fff' }}" class="squircle-img">
                    <div class="status-badge">TITANIUM</div>
                </div>
                <h3 style="font-size: 1.6rem; font-weight: 900; margin-bottom: 5px;">{{ $user->name }}</h3>
                <p style="color: #8c8c8c; font-weight: 600; font-size: 0.9rem;">Member ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                
                <div style="margin-top: 40px; display: grid; gap: 15px;">
                    <div style="background: rgba(255,255,255,0.5); padding: 15px; border-radius: 18px; text-align: left;">
                        <span style="display: block; font-size: 0.65rem; color: #86868b; font-weight: 800; text-transform: uppercase;">Joined Since</span>
                        <span style="font-weight: 800;">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Dynamic Form Stack -->
        <div class="forms-stack">
            
            <!-- Module 1: Personal Manifest -->
            <div class="module-card">
                <h3 class="module-title"><i>👤</i> Personal Manifest</h3>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="field-group">
                        <label>Identity Portrait</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="photo" id="photo" style="display: none;">
                            <label for="photo" style="cursor: pointer; margin: 0;">
                                <div style="font-size: 1.5rem; margin-bottom: 5px;">📸</div>
                                <span style="color: var(--titanium-orange); font-weight: 800;">Click to upload new portrait</span>
                                <p style="font-size: 0.7rem; color: #aeaeae; margin-top: 5px; text-transform: uppercase;">SVG, PNG, JPG (MAX 2MB)</p>
                            </label>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="field-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="input-premium" value="{{ $user->name }}" placeholder="Jane Doe">
                        </div>
                        <div class="field-group">
                            <label>Electronic Mail</label>
                            <input type="email" name="email" class="input-premium" value="{{ $user->email }}" placeholder="jane@apple.com">
                        </div>
                    </div>

                    <button type="submit" class="btn-action btn-primary">Synchronize Identity</button>
                </form>
            </div>

            <!-- Module 2: Encryption Key -->
            <div class="module-card">
                <h3 class="module-title"><i>🔐</i> Encryption Passphrase</h3>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    
                    <div class="field-group">
                        <label>Current Passphrase</label>
                        <input type="password" name="current_password" class="input-premium" placeholder="••••••••••••">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="field-group">
                            <label>New Passphrase</label>
                            <input type="password" name="password" class="input-premium" placeholder="Min. 8 characters">
                        </div>
                        <div class="field-group">
                            <label>Verify Passphrase</label>
                            <input type="password" name="password_confirmation" class="input-premium" placeholder="Repeat passphrase">
                        </div>
                    </div>

                    <button type="submit" class="btn-action btn-secondary">Rotate Encryption Key</button>
                </form>
            </div>

            <!-- Danger Zone Section -->
            <div style="text-align: center; margin-top: 20px;">
                <p style="color: #aeaeae; font-size: 0.8rem; font-weight: 600;">Looking to deactivate your account? <a href="#" style="color: #ff3b30; text-decoration: none;">Delete Manifest</a></p>
            </div>

        </div>
    </div>
</div>

<script>
    // Preview image on upload click (optional enhancement)
    document.getElementById('photo').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            document.querySelector('.squircle-img').src = URL.createObjectURL(file);
        }
    }
</script>
@endsection