@extends('layouts.app')

@section('content')
<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-titanium: #e85a24;
        --charcoal: #121212;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --input-bg: #f5f5f7;
    }

    .profile-wrapper {
        max-width: 1100px;
        margin: 60px auto;
        padding: 0 30px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* 1. HEADER SECTION */
    .header-info {
        margin-bottom: 50px;
        animation: fadeIn 0.8s ease;
    }

    .header-info h1 {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -2.5px;
        color: var(--charcoal);
        margin: 0;
    }

    .header-info span { color: var(--titanium-orange); }

    /* 2. MAIN GRID LAYOUT */
    .profile-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 40px;
        align-items: start;
    }

    /* 3. AVATAR CARD - LEFT */
    .avatar-card {
        background: white;
        border-radius: 40px;
        padding: 40px;
        text-align: center;
        border: 1px solid #f0f0f2;
        box-shadow: 0 20px 40px rgba(0,0,0,0.02);
        position: sticky;
        top: 100px;
    }

    .profile-img-big {
        width: 140px;
        height: 140px;
        border-radius: 50px; /* Squircle style */
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        transition: 0.4s;
    }

    .avatar-card:hover .profile-img-big {
        transform: scale(1.05) rotate(3deg);
    }

    .user-tag {
        font-size: 0.75rem;
        font-weight: 900;
        color: var(--titanium-orange);
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    /* 4. SETTINGS FORM - RIGHT */
    .settings-main {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .titanium-card {
        background: white;
        border-radius: 40px;
        padding: 45px;
        border: 1px solid #f0f0f2;
        box-shadow: 0 20px 40px rgba(0,0,0,0.02);
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 900;
        letter-spacing: -1px;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title::before {
        content: "";
        width: 8px;
        height: 24px;
        background: var(--titanium-orange);
        border-radius: 4px;
    }

    /* Form Design */
    .form-group-modern {
        margin-bottom: 25px;
    }

    .form-group-modern label {
        display: block;
        font-size: 0.8rem;
        font-weight: 800;
        color: #86868b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        margin-left: 5px;
    }

    .input-titanium {
        width: 100%;
        background: var(--input-bg);
        border: 2px solid transparent;
        padding: 18px 25px;
        border-radius: 20px;
        font-size: 1rem;
        font-weight: 700;
        color: var(--charcoal);
        transition: 0.3s;
    }

    .input-titanium:focus {
        background: white;
        border-color: var(--titanium-orange);
        box-shadow: 0 10px 20px rgba(255, 107, 53, 0.05);
        outline: none;
    }

    /* 5. BUTTONS */
    .btn-save {
        background: var(--charcoal);
        color: white;
        padding: 20px 40px;
        border-radius: 20px;
        font-weight: 800;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        width: 100%;
        margin-top: 10px;
    }

    .btn-save:hover {
        background: var(--titanium-orange);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 107, 53, 0.3);
    }

    .alert-titanium {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 20px;
        border-radius: 22px;
        font-weight: 800;
        margin-bottom: 30px;
        border: 1px solid #c8e6c9;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 900px) {
        .profile-grid { grid-template-columns: 1fr; }
        .avatar-card { position: relative; top: 0; }
        .header-info h1 { font-size: 2.2rem; }
    }
</style>

<div class="profile-wrapper">
    
    <div class="header-info">
        <span class="user-tag">Identity Protocol</span>
        <h1>Account <span>Settings.</span></h1>
    </div>

    @if(session('success'))
        <div class="alert-titanium">
            <span>✨</span> {{ session('success') }}
        </div>
    @endif

    <div class="profile-grid">
        
        <aside class="avatar-card">
            <img src="{{ $user->photo ? asset('storage/'.$user->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=ff6b35&color=fff' }}" class="profile-img-big">
            <h3 style="margin: 0; font-weight: 900; font-size: 1.4rem;">{{ $user->name }}</h3>
            <p style="color: #86868b; font-size: 0.9rem; font-weight: 600; margin-top: 5px;">{{ $user->email }}</p>
            
            <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #f2f2f7;">
                <p style="font-size: 0.75rem; color: #aeaeae; font-weight: 800;">TITANIUM MEMBER SINCE</p>
                <p style="font-weight: 800; color: var(--charcoal);">{{ $user->created_at->format('Y') }}</p>
            </div>
        </aside>

        <main class="settings-main">
            
            <div class="titanium-card">
                <h3 class="section-title">Personal Manifest</h3>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group-modern">
                        <label>Profile Image</label>
                        <input type="file" name="photo" class="input-titanium" style="padding: 15px;">
                        <span style="font-size: 0.7rem; color: #aeaeae; margin-top: 8px; display: block; font-weight: 700;">RECOMMENDED: SQUIRCLE RATIO 1:1 (MAX 2MB)</span>
                    </div>

                    <div class="form-group-modern">
                        <label>Full Name</label>
                        <input type="text" name="name" class="input-titanium" value="{{ $user->name }}">
                    </div>

                    <div class="form-group-modern">
                        <label>Electronic Mail</label>
                        <input type="email" name="email" class="input-titanium" value="{{ $user->email }}">
                    </div>

                    <button type="submit" class="btn-save">Sync Profile Data</button>
                </form>
            </div>

            <div class="titanium-card">
                <h3 class="section-title">Encryption Key</h3>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    
                    <div class="form-group-modern">
                        <label>Current Password</label>
                        <input type="password" name="current_password" class="input-titanium" placeholder="••••••••••••">
                    </div>

                    <div class="form-group-modern">
                        <label>New Passphrase</label>
                        <input type="password" name="password" class="input-titanium" placeholder="At least 8 characters">
                    </div>

                    <div class="form-group-modern">
                        <label>Verify Passphrase</label>
                        <input type="password" name="password_confirmation" class="input-titanium" placeholder="Repeat new password">
                    </div>

                    <button type="submit" class="btn-save" style="background: #e5e5e7; color: var(--charcoal);">Update Encryption</button>
                </form>
            </div>

        </main>
    </div>
</div>
@endsection