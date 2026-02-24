@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between py-10">
        <style>
            .pg-container {
                display: flex;
                align-items: center;
                gap: 8px;
                background: rgba(255, 255, 255, 0.5);
                padding: 8px;
                border-radius: 30px;
                border: 1px solid #eef0f2;
                backdrop-filter: blur(10px);
            }

            .pg-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 48px;
                min-width: 48px;
                padding: 0 12px;
                border-radius: 50% !important; /* Bikin bener-bener bulet */
                font-size: 0.95rem;
                font-weight: 800;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Efek pop-out */
                text-decoration: none;
                border: none;
                background: transparent;
                color: #86868b;
            }

            .pg-btn-active {
                background: #121212 !important;
                color: #ff6b35 !important;
                transform: scale(1.1);
                box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            }

            .pg-btn:hover:not(.pg-btn-disabled):not(.pg-btn-active) {
                background: white;
                color: #ff6b35;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
                transform: translateY(-3px);
            }

            .pg-btn-disabled {
                opacity: 0.3;
                cursor: not-allowed;
            }

            /* Tombol Panah Spesial */
            .pg-arrow {
                background: #ffffff;
                color: #121212;
                border: 1px solid #eef0f2;
                box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            }

            .pg-arrow:hover:not(.pg-btn-disabled) {
                background: #121212;
                color: white;
                border-color: #121212;
            }

            .pg-info-pill {
                background: #121212;
                color: #ffffff;
                padding: 6px 16px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 1px;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .pg-info-pill span {
                color: #ff6b35;
            }
        </style>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between w-full">
            <div>
                <div class="pg-info-pill">
                    Status <span>•</span> {{ $paginator->total() }} Units Logged
                </div>
            </div>

            <div class="pg-container">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="pg-btn pg-arrow pg-btn-disabled">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="pg-btn pg-arrow">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                <div class="flex items-center gap-1">
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="pg-btn pg-btn-disabled">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="pg-btn pg-btn-active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="pg-btn">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="pg-btn pg-arrow">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @else
                    <span class="pg-btn pg-arrow pg-btn-disabled">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                    </span>
                @endif
            </div>
        </div>

        {{-- Mobile View (Minimalist) --}}
        <div class="flex flex-1 justify-center gap-4 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="pg-btn pg-arrow pg-btn-disabled">←</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pg-btn pg-arrow">←</a>
            @endif
            
            <div class="pg-info-pill" style="height:48px">
                {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pg-btn pg-arrow">→</a>
            @else
                <span class="pg-btn pg-arrow pg-btn-disabled">→</span>
            @endif
        </div>
    </nav>
@endif