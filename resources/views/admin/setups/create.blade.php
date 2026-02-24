@extends('layouts.admin')

@section('content')

<style>
    :root {
        --titanium-orange: #ff6b35;
        --deep-orange: #e85a24;
        --glass-bg: rgba(255, 255, 255, 0.3);
        --glass-border: rgba(255, 255, 255, 0.5);
        --text-main: #2d1a12;
        --text-muted: #8a7b75;
    }

    .setup-container {
        max-width: 1100px;
        margin: 0 auto;
        animation: liquidFlow 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 20px;
    }

    /* HEADER */
    .setup-header { margin-bottom: 40px; }
    .setup-header h1 { font-size: 2.8rem; font-weight: 900; letter-spacing: -2px; color: var(--text-main); margin: 0; }
    .setup-header p { font-weight: 700; color: var(--deep-orange); margin-top: 5px; }

    /* LAYOUT GRID */
    .setup-grid { display: grid; grid-template-columns: 1fr 1.6fr; gap: 35px; align-items: start; }

    /* GLASS PANEL */
    .glass-panel {
        background: var(--glass-bg);
        backdrop-filter: blur(30px) saturate(160%);
        -webkit-backdrop-filter: blur(30px) saturate(160%);
        border-radius: 40px;
        padding: 40px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 25px 50px rgba(0,0,0,0.04);
    }

    .input-group { margin-bottom: 25px; }
    .input-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: var(--deep-orange); margin-bottom: 12px; display: block; }

    /* INPUT STYLING */
    input[type="text"], input[type="number"], textarea {
        width: 100%; background: rgba(255, 255, 255, 0.5); border: 1px solid var(--glass-border);
        padding: 18px 25px; border-radius: 22px; font-family: inherit; font-weight: 700; color: var(--text-main);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    input:focus, textarea:focus { outline: none; background: white; border-color: var(--titanium-orange); transform: translateY(-3px); }

    /* PRICE WRAPPER */
    .price-wrapper { position: relative; display: flex; align-items: center; }
    .price-wrapper .currency { position: absolute; left: 25px; font-weight: 900; color: var(--deep-orange); }
    .price-wrapper input { padding-left: 55px; font-size: 1.2rem; color: var(--deep-orange); font-weight: 900; }

    /* UPLOAD ZONE */
    .upload-zone {
        position: relative; border: 2px dashed var(--glass-border); border-radius: 25px;
        padding: 30px; text-align: center; transition: 0.3s; background: rgba(255, 255, 255, 0.2); cursor: pointer;
    }
    .upload-zone:hover { border-color: var(--titanium-orange); background: rgba(255, 255, 255, 0.5); }
    .upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 2; }
    
    #image-preview-now { width: 100%; border-radius: 20px; display: none; margin-top: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    /* HARDWARE PICKER */
    .hardware-picker { 
        display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); 
        gap: 15px; max-height: 520px; overflow-y: auto; padding-right: 15px; 
    }
    .hardware-card { 
        background: rgba(255, 255, 255, 0.4); border: 1px solid var(--glass-border); 
        border-radius: 28px; padding: 25px 15px; cursor: pointer; transition: 0.4s; text-align: center; position: relative; 
    }
    .hardware-card input[type="checkbox"] { display: none; }
    .hardware-card:hover { transform: translateY(-5px); background: white; }
    
    .hardware-card:has(input:checked) { background: var(--text-main); border-color: var(--titanium-orange); }
    .hardware-card:has(input:checked) .product-name { color: white; }
    .hardware-card:has(input:checked)::after {
        content: "✓"; position: absolute; top: 12px; right: 18px; color: var(--titanium-orange); font-weight: 900; font-size: 1.2rem;
    }
    .product-name { font-size: 0.85rem; font-weight: 800; color: var(--text-main); display: block; }

    /* BUTTONS */
    .btn-deploy {
        width: 100%; background: linear-gradient(135deg, var(--titanium-orange), var(--deep-orange));
        color: white; border: none; padding: 24px; border-radius: 25px; font-weight: 900; 
        text-transform: uppercase; letter-spacing: 2px; cursor: pointer; transition: 0.4s;
        box-shadow: 0 20px 40px rgba(232, 90, 36, 0.25); margin-top: 25px;
    }
    .btn-deploy:hover { transform: translateY(-4px); filter: brightness(1.1); }

    @keyframes liquidFlow { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @media (max-width: 950px) { .setup-grid { grid-template-columns: 1fr; } }
</style>

<div class="setup-container">
    <header class="setup-header">
        <h1>{{ isset($setup) ? 'Edit Setup' : 'Configure Setup' }}</h1>
        <p>Create a curated hardware bundle experience.</p>
    </header>

    {{-- FIX: Ditambahkan enctype agar file bisa terkirim --}}
    <form action="{{ isset($setup) ? route('admin.setups.update', $setup) : route('admin.setups.store') }}" 
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($setup)) @method('PUT') @endif

        <div class="setup-grid">
            
            <div class="glass-panel">
                <div class="input-group">
                    <label class="input-label">Setup Identification</label>
                    <input type="text" name="name" placeholder="e.g. Ultimate Creator Station" value="{{ old('name', $setup->name ?? '') }}" required>
                </div>

                <div class="input-group">
                    <label class="input-label">Configuration Details</label>
                    <textarea name="description" placeholder="Describe the specs and purpose..." rows="5">{{ old('description', $setup->description ?? '') }}</textarea>
                </div>

                <div class="input-group">
                    <label class="input-label">Bundle Valuation</label>
                    <div class="price-wrapper">
                        <span class="currency">Rp</span>
                        <input type="number" name="price" placeholder="0" value="{{ old('price', $setup->price ?? '') }}" required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Visual Asset (Thumbnail)</label>
                    <div class="upload-zone" id="upload-zone">
                        <input type="file" name="image" id="image-input" accept="image/*">
                        <div id="upload-placeholder">
                            <span style="font-size: 2rem;">📸</span><br>
                            <span style="font-size: 0.8rem; font-weight: 800;">Click or Drag Image Here</span>
                        </div>
                        <img id="image-preview-now" src="#" alt="Preview">
                    </div>

                    @if(isset($setup->image) && $setup->image)
                        <div style="margin-top: 15px;">
                            <span class="input-label" style="font-size: 0.6rem; opacity: 0.6;">Current Active Image:</span>
                            <img src="{{ asset('storage/'.$setup->image) }}" width="120" style="border-radius: 15px; border: 1px solid var(--glass-border);">
                        </div>
                    @endif
                </div>
            </div>

            <div class="glass-panel">
                <label class="input-label">Hardware Inventory Picker</label>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px; font-weight: 600;">
                    Select components to be integrated into this bundle:
                </p>

                <div class="hardware-picker">
                    @foreach($products as $product)
                        <label class="hardware-card">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}" 
                                {{ (isset($setup) && $setup->products->contains($product->id)) ? 'checked' : '' }}>
                            <div style="font-size: 1.8rem; margin-bottom: 12px;">🔌</div>
                            <span class="product-name">{{ $product->name }}</span>
                            <span style="font-size: 0.7rem; opacity: 0.6; font-weight: 800; margin-top: 8px; display: block;">
                                ID: #{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="btn-deploy">
                    {{ isset($setup) ? 'Update Configuration' : 'Deploy Configuration' }}
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // Script untuk Instant Image Preview
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview-now');
    const uploadPlaceholder = document.getElementById('upload-placeholder');

    imageInput.onchange = evt => {
        const [file] = imageInput.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
            imagePreview.style.display = 'block';
            uploadPlaceholder.style.display = 'none';
        }
    }
</script>

@endsection