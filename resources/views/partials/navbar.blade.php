<!-- Amazon-Style Header -->
<header class="amz-header">
    <!-- Top Bar - 3 Section Flexbox Layout -->
    <div class="amz-navbar-top d-flex align-items-center"
        style="background-color: #131921; height: 60px; padding: 0 10px;">

        <!-- LEFT SECTION (Fixed Width): Brand + Location -->
        <div class="d-flex align-items-center flex-shrink-0">
            <!-- Logo -->
            <a href="{{ route('home') }}"
                class="amz-logo-link d-flex align-items-baseline text-decoration-none px-2 py-1 rounded"
                style="border: 1px solid transparent;">
                <span class="fw-bold text-white" style="font-size: 22px; letter-spacing: -0.5px;">EEZEPC</span><span
                    class="fw-bold" style="color: #ff9900; font-size: 22px;">.com</span>
            </a>

            <!-- Location Widget -->
            <div class="amz-location d-flex align-items-center px-2 py-1 rounded ms-2"
                style="cursor: pointer; border: 1px solid transparent;"
                onclick="document.getElementById('countrySelector').click()">
                <div class="me-1 align-self-end mb-1 text-white">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="d-flex flex-column" style="line-height: 1.1;">
                    <span style="font-size: 12px; color: #ccc;">Deliver to</span>
                    <span class="text-white fw-bold" style="font-size: 14px;" id="deliverToCountry">Pakistan</span>
                </div>
            </div>
        </div>

        <!-- MIDDLE SECTION (Fluid): Search Bar - Takes ALL remaining space -->
        <div class="flex-grow-1 mx-3 position-relative align-self-center" id="searchContainer">
            <form class="w-100" action="{{ route('products.search') }}" method="GET" id="searchForm">
                <div class="input-group" style="height: 40px; border-radius: 4px; overflow: hidden; margin-top: 10px;">
                    <!-- Category Dropdown - Dynamic from Database -->
                    <select class="form-select flex-shrink-0" name="category" id="searchCategory"
                        style="max-width: 150px; background-color: #f3f3f3; border: none; border-right: 1px solid #cdcdcd; font-size: 12px; border-radius: 0; padding: 0 8px;">
                        <option value="">All Categories</option>
                        @isset($navCategories)
                            @foreach($navCategories as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @if($category->children->count() > 0)
                                    @foreach($category->children as $child)
                                        <option value="{{ $child->slug }}">&nbsp;&nbsp;└ {{ $child->name }}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endisset
                    </select>
                    <!-- Search Input -->
                    <input type="text" class="form-control" name="q" id="searchInput" placeholder="Search EEZEPC"
                        autocomplete="off" style="border: none; font-size: 15px; padding: 0 12px; flex: 1;">
                    <!-- Search Button -->
                    <button type="submit" class="btn d-flex align-items-center justify-content-center"
                        style="background-color: #febd69; border: none; width: 45px; border-radius: 0;">
                        <i class="fa-solid fa-magnifying-glass" style="color: #131921;"></i>
                    </button>
                </div>
            </form>

            <!-- Search Results Dropdown -->
            <div id="searchResults" class="position-absolute w-100 bg-white shadow-lg rounded-bottom"
                style="display: none; top: 40px; left: 0; z-index: 1050; max-height: 400px; overflow-y: auto; border: 1px solid #ddd;">
            </div>
        </div>

        <!-- RIGHT SECTION (Fixed Width): Country, Account, Returns, Cart -->
        <div class="d-flex align-items-center flex-shrink-0">
            <!-- Country/Language Selector -->
            <div class="amz-country-selector d-flex align-items-center px-2 py-1 rounded" id="countrySelector"
                style="cursor: pointer; border: 1px solid transparent;">
                <img src="https://flagcdn.com/w20/us.png" alt="US" class="me-1" id="currentFlag"
                    style="width: 20px; height: 15px; object-fit: cover;">
                <span class="text-white fw-bold" id="currentCode" style="font-size: 14px;">EN</span>
                <i class="fa-solid fa-caret-down fa-xs ms-1" style="color: #999;"></i>
            </div>

            <!-- Account & Lists (with Dropdown for Logout) -->
            @auth
                <div class="dropdown">
                    <a href="#"
                        class="amz-nav-item d-flex flex-column justify-content-center text-decoration-none text-white px-2 py-1 rounded dropdown-toggle"
                        style="line-height: 1.1; border: 1px solid transparent;" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" data-bs-auto-close="true">
                        <span style="font-size: 12px;">Hello, {{ auth()->user()->name }}</span>
                        <span class="fw-bold" style="font-size: 14px;">Account & Lists</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end"
                        style="min-width: 200px; border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.15);">
                        <li class="px-3 py-2" style="border-bottom: 1px solid #eee;">
                            <span class="fw-bold" style="font-size: 14px;">{{ auth()->user()->name }}</span><br>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </li>
                        <li>
                            <a class="dropdown-item py-2"
                                href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('account') }}">
                                <i
                                    class="fa-solid fa-user me-2"></i>{{ auth()->user()->is_admin ? 'Admin Dashboard' : 'Your Account' }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('wishlist.index') }}">
                                <i class="fa-solid fa-heart me-2"></i>Your Wishlist
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fa-solid fa-sign-out-alt me-2"></i>Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="amz-nav-item d-flex flex-column justify-content-center text-decoration-none text-white px-2 py-1 rounded"
                    style="line-height: 1.1; border: 1px solid transparent;">
                    <span style="font-size: 12px;">Hello, sign in</span>
                    <span class="fw-bold" style="font-size: 14px;">Account & Lists</span>
                </a>
            @endauth

            <!-- Orders -->
            <a href="{{ route('orders.index') }}"
                class="amz-nav-item d-flex flex-column justify-content-center text-decoration-none text-white px-2 py-1 rounded"
                style="line-height: 1.1; border: 1px solid transparent;">
                <span style="font-size: 12px;">Your</span>
                <span class="fw-bold" style="font-size: 14px;">Orders</span>
            </a>

            <!-- Cart -->
            <a href="{{ route('cart.view') }}"
                class="d-flex align-items-end text-decoration-none text-white px-2 py-1 rounded"
                style="border: 1px solid transparent;">
                <div class="position-relative" style="margin-right: 2px;">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 28px;"></i>
                    <span class="position-absolute fw-bold d-flex align-items-center justify-content-center"
                        style="top: -2px; left: 50%; transform: translateX(-50%); color: #f08804; font-size: 15px; min-width: 18px;">{{ count(session('cart', [])) }}</span>
                </div>
                <span class="fw-bold ms-1" style="font-size: 14px;">Cart</span>
            </a>
        </div>
    </div>

    <!-- Sub-Navigation - Premium Amazon-Style -->
    <nav class="amz-subnav-premium">
        <div class="subnav-container">
            <!-- Quick Links Section -->
            <div class="subnav-quick-links">
                <a href="{{ route('deals') }}" class="subnav-item subnav-item--featured">
                    <span class="subnav-icon">
                        <i class="fas fa-bolt"></i>
                    </span>
                    <span class="subnav-text">Today's Deals</span>
                    <span class="subnav-glow"></span>
                </a>

                <a href="{{ route('wishlist.index') }}" class="subnav-item subnav-item--wishlist">
                    <span class="subnav-icon">
                        <i class="fas fa-heart"></i>
                    </span>
                    <span class="subnav-text">Your Wishlist</span>
                    @if(count(session('wishlist', [])) > 0)
                        <span class="subnav-count">{{ count(session('wishlist', [])) }}</span>
                    @endif
                    <span class="subnav-glow"></span>
                </a>
            </div>

            <!-- Divider -->
            <div class="subnav-separator"></div>

            <!-- Category Links Section -->
            <div class="subnav-categories">
                @isset($navCategories)
                    @php
                        $categoryIcons = [
                            'laptops' => 'fa-laptop',
                            'desktop' => 'fa-desktop',
                            'graphics' => 'fa-microchip',
                            'processors' => 'fa-microchip',
                            'storage' => 'fa-hard-drive',
                            'monitors' => 'fa-tv',
                            'gaming' => 'fa-gamepad',
                            'accessories' => 'fa-keyboard',
                            'phones' => 'fa-mobile-alt',
                            'audio' => 'fa-headphones',
                            'default' => 'fa-cube'
                        ];
                    @endphp
                    @foreach($navCategories->take(6) as $category)
                        @php
                            $iconKey = strtolower(str_replace([' ', '-'], '', $category->name));
                            $icon = 'fa-cube';
                            foreach ($categoryIcons as $key => $value) {
                                if (str_contains($iconKey, $key)) {
                                    $icon = $value;
                                    break;
                                }
                            }
                        @endphp
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="subnav-item">
                            <span class="subnav-icon">
                                <i class="fas {{ $icon }}"></i>
                            </span>
                            <span class="subnav-text">{{ $category->name }}</span>
                            <span class="subnav-glow"></span>
                        </a>
                    @endforeach
                @endisset
            </div>
        </div>
    </nav>
</header>

<style>
    /* ===== PREMIUM SUBNAV STYLES ===== */
    .amz-subnav-premium {
        background: linear-gradient(180deg, #232F3E 0%, #1a242f 100%);
        border-top: 1px solid rgba(255, 153, 0, 0.15);
        border-bottom: 1px solid rgba(0, 0, 0, 0.3);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        position: relative;
        overflow: hidden;
    }

    .amz-subnav-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg,
                transparent 0%,
                rgba(255, 153, 0, 0.4) 20%,
                rgba(255, 153, 0, 0.6) 50%,
                rgba(255, 153, 0, 0.4) 80%,
                transparent 100%);
    }

    .subnav-container {
        display: flex;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
        height: 46px;
    }

    .subnav-quick-links,
    .subnav-categories {
        display: flex;
        align-items: center;
        gap: 4px;
        height: 100%;
    }

    .subnav-categories {
        flex: 1;
        justify-content: center;
    }

    .subnav-separator {
        width: 1px;
        height: 24px;
        background: linear-gradient(180deg,
                transparent 0%,
                rgba(255, 153, 0, 0.4) 50%,
                transparent 100%);
        margin: 0 16px;
    }

    /* Individual Nav Item */
    .subnav-item {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        color: rgba(255, 255, 255, 0.88);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.02em;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .subnav-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg,
                rgba(255, 153, 0, 0.08) 0%,
                rgba(255, 153, 0, 0.02) 100%);
        border-radius: 6px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .subnav-item:hover {
        color: #fff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .subnav-item:hover::before {
        opacity: 1;
    }

    .subnav-item:active {
        transform: translateY(0) scale(0.98);
    }

    /* Icon Styling */
    .subnav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        background: linear-gradient(135deg, rgba(255, 153, 0, 0.15) 0%, rgba(255, 153, 0, 0.05) 100%);
        border-radius: 6px;
        border: 1px solid rgba(255, 153, 0, 0.2);
        transition: all 0.3s ease;
    }

    .subnav-icon i {
        font-size: 11px;
        color: #FF9900;
        transition: all 0.3s ease;
    }

    .subnav-item:hover .subnav-icon {
        background: linear-gradient(135deg, #FF9900 0%, #FEBD69 100%);
        border-color: transparent;
        transform: scale(1.1) rotate(-3deg);
        box-shadow: 0 4px 12px rgba(255, 153, 0, 0.4);
    }

    .subnav-item:hover .subnav-icon i {
        color: #0F1111;
    }

    /* Text Styling */
    .subnav-text {
        position: relative;
        z-index: 1;
    }

    .subnav-text::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #FF9900, #FEBD69);
        border-radius: 1px;
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .subnav-item:hover .subnav-text::after {
        width: 100%;
    }

    /* Glow Effect */
    .subnav-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 120%;
        height: 120%;
        background: radial-gradient(circle, rgba(255, 153, 0, 0.15) 0%, transparent 70%);
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.4s ease;
        pointer-events: none;
    }

    .subnav-item:hover .subnav-glow {
        transform: translate(-50%, -50%) scale(1);
    }

    /* Featured Item (Deals) */
    .subnav-item--featured .subnav-icon {
        background: linear-gradient(135deg, rgba(255, 89, 0, 0.2) 0%, rgba(255, 153, 0, 0.1) 100%);
        border-color: rgba(255, 89, 0, 0.3);
        animation: pulse-glow 2s ease-in-out infinite;
    }

    .subnav-item--featured .subnav-icon i {
        color: #FF5900;
    }

    @keyframes pulse-glow {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(255, 89, 0, 0);
        }

        50% {
            box-shadow: 0 0 12px 2px rgba(255, 89, 0, 0.25);
        }
    }

    /* Wishlist Item */
    .subnav-item--wishlist .subnav-icon i {
        color: #FF6B6B;
    }

    .subnav-item--wishlist:hover .subnav-icon {
        background: linear-gradient(135deg, #FF6B6B 0%, #FF8E8E 100%);
    }

    /* Count Badge */
    .subnav-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        background: linear-gradient(135deg, #FF9900 0%, #FEBD69 100%);
        color: #0F1111;
        font-size: 11px;
        font-weight: 700;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(255, 153, 0, 0.3);
        animation: badge-bounce 0.4s ease;
    }

    @keyframes badge-bounce {
        0% {
            transform: scale(0);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .subnav-categories {
            justify-content: flex-end;
        }

        .subnav-item {
            padding: 8px 12px;
        }

        .subnav-text {
            font-size: 12px;
        }
    }

    @media (max-width: 992px) {
        .subnav-categories {
            display: none;
        }

        .subnav-separator {
            display: none;
        }

        .subnav-quick-links {
            flex: 1;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .subnav-container {
            padding: 0 12px;
            height: 42px;
        }

        .subnav-icon {
            width: 22px;
            height: 22px;
        }

        .subnav-icon i {
            font-size: 10px;
        }
    }

    /* ===== PREMIUM SEARCH BAR STYLES ===== */
    .premium-search-wrapper {
        width: 100%;
        display: flex;
        align-items: center;
    }

    .premium-search-bar {
        position: relative;
        display: flex;
        align-items: center;
        height: 46px;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }

    .premium-search-bar:hover {
        box-shadow: 0 4px 20px rgba(255, 153, 0, 0.15);
    }

    .premium-search-bar:focus-within {
        border-color: #FF9900;
        box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.2), 0 4px 20px rgba(255, 153, 0, 0.25);
    }

    /* Animated Glow Effect */
    .search-glow {
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(90deg, #FF9900, #FEBD69, #FF9900);
        background-size: 200% 100%;
        border-radius: 10px;
        opacity: 0;
        z-index: -1;
        transition: opacity 0.3s ease;
        animation: glow-shift 3s linear infinite;
    }

    .premium-search-bar:focus-within .search-glow {
        opacity: 1;
    }

    @keyframes glow-shift {
        0% {
            background-position: 0% 50%;
        }

        100% {
            background-position: 200% 50%;
        }
    }

    /* Category Dropdown Wrapper */
    .search-category-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        height: 100%;
        background: linear-gradient(180deg, #f7f7f7 0%, #e8e8e8 100%);
        border-right: 1px solid #ddd;
        transition: all 0.2s ease;
    }

    .search-category-wrapper:hover {
        background: linear-gradient(180deg, #f0f0f0 0%, #e0e0e0 100%);
    }

    .search-category-select {
        appearance: none;
        -webkit-appearance: none;
        border: none;
        background: transparent;
        padding: 0 32px 0 14px;
        height: 100%;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        min-width: 140px;
        outline: none;
    }

    .search-category-select option {
        padding: 10px;
        font-size: 13px;
    }

    .search-category-arrow {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 10px;
        color: #666;
        pointer-events: none;
        transition: transform 0.2s ease;
    }

    .search-category-wrapper:hover .search-category-arrow {
        transform: translateY(-50%) rotate(180deg);
    }

    /* Divider */
    .search-divider {
        width: 1px;
        height: 60%;
        background: #ccc;
        flex-shrink: 0;
    }

    /* Search Input Wrapper */
    .search-input-wrapper {
        position: relative;
        flex: 1;
        height: 100%;
        overflow: hidden;
    }

    .search-input {
        width: 100%;
        height: 100%;
        border: none;
        padding: 0 16px;
        font-size: 15px;
        color: #0F1111;
        background: transparent;
        outline: none !important;
        box-shadow: none !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .search-input:focus {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
    }

    /* Remove all webkit search decorations */
    .search-input::-webkit-search-decoration,
    .search-input::-webkit-search-cancel-button,
    .search-input::-webkit-search-results-button,
    .search-input::-webkit-search-results-decoration {
        display: none;
    }

    .search-input::placeholder {
        color: #999;
        font-weight: 400;
    }

    .search-input:focus::placeholder {
        color: #bbb;
    }

    .search-input-highlight {
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #FF9900, #FEBD69);
        transform: translateX(-50%);
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .search-input:focus~.search-input-highlight {
        width: 100%;
    }

    /* Search Button */
    .search-button {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 100%;
        background: linear-gradient(180deg, #FFB84D 0%, #FF9900 50%, #E68A00 100%);
        border: none;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .search-button:hover {
        background: linear-gradient(180deg, #FFC266 0%, #FFAD33 50%, #FF9900 100%);
    }

    .search-button:active {
        transform: scale(0.98);
    }

    .search-icon {
        font-size: 18px;
        color: #0F1111;
        z-index: 1;
        transition: transform 0.2s ease;
    }

    .search-button:hover .search-icon {
        transform: scale(1.15);
    }

    .search-button-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s ease;
    }

    .search-button:hover .search-button-shine {
        left: 100%;
    }

    /* Premium Search Results Dropdown */
    .premium-search-results {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15), 0 2px 8px rgba(0, 0, 0, 0.08);
        z-index: 1050;
        max-height: 450px;
        overflow-y: auto;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .premium-search-results::-webkit-scrollbar {
        width: 6px;
    }

    .premium-search-results::-webkit-scrollbar-track {
        background: #f5f5f5;
        border-radius: 3px;
    }

    .premium-search-results::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #FF9900, #E68A00);
        border-radius: 3px;
    }

    /* Search Result Item */
    .search-result-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .search-result-item:hover {
        background: linear-gradient(90deg, #FFF8EE 0%, #fff 100%);
        padding-left: 20px;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-image {
        width: 50px;
        height: 50px;
        object-fit: contain;
        border-radius: 8px;
        background: #f9f9f9;
        padding: 4px;
        flex-shrink: 0;
    }

    .search-result-info {
        flex: 1;
        min-width: 0;
    }

    .search-result-name {
        font-size: 14px;
        font-weight: 600;
        color: #0F1111;
        margin-bottom: 2px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .search-result-name mark {
        background: linear-gradient(90deg, #FEBD69, #FFF3CD);
        color: #0F1111;
        padding: 0 2px;
        border-radius: 2px;
    }

    .search-result-price {
        font-size: 15px;
        font-weight: 700;
        color: #B12704;
    }

    .search-result-category {
        font-size: 12px;
        color: #666;
    }

    .search-result-category::before {
        content: 'in ';
        color: #999;
    }

    /* View All Results Link */
    .search-view-all {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        background: linear-gradient(180deg, #f9f9f9 0%, #f0f0f0 100%);
        color: #0066C0;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-top: 1px solid #e0e0e0;
        transition: all 0.2s ease;
    }

    .search-view-all:hover {
        background: linear-gradient(180deg, #f0f0f0 0%, #e8e8e8 100%);
        color: #C45500;
    }

    .search-view-all i {
        transition: transform 0.2s ease;
    }

    .search-view-all:hover i {
        transform: translateX(4px);
    }

    /* No Results */
    .search-no-results {
        padding: 32px 20px;
        text-align: center;
    }

    .search-no-results i {
        font-size: 40px;
        color: #ddd;
        margin-bottom: 12px;
    }

    .search-no-results p {
        color: #666;
        font-size: 14px;
        margin: 0;
    }

    /* Responsive Search */
    @media (max-width: 768px) {
        .search-category-wrapper {
            display: none;
        }

        .search-divider {
            display: none;
        }

        .premium-search-bar {
            height: 42px;
        }

        .search-button {
            width: 48px;
        }

        .search-input {
            font-size: 14px;
        }
    }
</style>

<!-- Country Selector Modal (Hidden by default) -->
<div class="modal fade" id="countryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose your country</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control mb-3" id="countrySearch" placeholder="Search country...">
                <div class="list-group" id="countryList" style="max-height: 300px; overflow-y: auto;">
                    <!-- Countries will be populated here via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ===== AJAX SEARCH FUNCTIONALITY =====
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const searchCategory = document.getElementById('searchCategory');
            let searchTimeout = null;

            // Search input handler with debounce
            searchInput.addEventListener('input', function () {
                const query = this.value.trim();

                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            });

            // Perform AJAX search
            async function performSearch(query) {
                const category = searchCategory.value;
                const url = new URL('{{ route("products.search") }}', window.location.origin);
                url.searchParams.set('q', query);
                if (category) {
                    url.searchParams.set('category', category);
                }
                url.searchParams.set('ajax', '1');

                try {
                    const response = await fetch(url);
                    const products = await response.json();
                    displayResults(products, query);
                } catch (error) {
                    console.error('Search error:', error);
                    searchResults.style.display = 'none';
                }
            }

            // Display search results
            function displayResults(products, query) {
                if (products.length === 0) {
                    searchResults.innerHTML = `
                                                    <div class="search-no-results">
                                                        <i class="fas fa-search"></i>
                                                        <p>No products found for "<strong>${escapeHtml(query)}</strong>"</p>
                                                    </div>
                                                `;
                    searchResults.style.display = 'block';
                    return;
                }

                let html = '';
                products.forEach(product => {
                    const imageUrl = product.image || '/images/placeholder.png';
                    const price = new Intl.NumberFormat('en-PK', { style: 'currency', currency: 'PKR', minimumFractionDigits: 0 }).format(product.price);

                    html += `
                                                    <a href="/products/${product.slug}" class="search-result-item">
                                                        <img src="${imageUrl}" alt="${escapeHtml(product.name)}" class="search-result-image">
                                                        <div class="search-result-info">
                                                            <div class="search-result-name">${highlightMatch(product.name, query)}</div>
                                                            <div class="search-result-price">${price}</div>
                                                            ${product.category_name ? `<span class="search-result-category">${escapeHtml(product.category_name)}</span>` : ''}
                                                        </div>
                                                    </a>
                                                `;
                });

                // Add "View all results" link
                html += `
                                                <a href="{{ route('products.search') }}?q=${encodeURIComponent(query)}&category=${searchCategory.value}" class="search-view-all">
                                                    <i class="fas fa-search"></i>
                                                    View all results for "${escapeHtml(query)}"
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            `;

                searchResults.innerHTML = html;
                searchResults.style.display = 'block';
            }

            // Helper functions
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function highlightMatch(text, query) {
                const escaped = escapeHtml(text);
                const regex = new RegExp(`(${escapeHtml(query)})`, 'gi');
                return escaped.replace(regex, '<strong style="color: #c7511f;">$1</strong>');
            }

            // Hide results when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('#searchContainer')) {
                    searchResults.style.display = 'none';
                }
            });

            // Show results on focus if there's content
            searchInput.addEventListener('focus', function () {
                if (this.value.trim().length >= 2 && searchResults.innerHTML) {
                    searchResults.style.display = 'block';
                }
            });

            // ===== COUNTRY SELECTOR =====
            const countrySelector = document.getElementById('countrySelector');
            const countryModal = new bootstrap.Modal(document.getElementById('countryModal'));
            const countryList = document.getElementById('countryList');
            const countrySearch = document.getElementById('countrySearch');
            const currentFlag = document.getElementById('currentFlag');
            const currentCode = document.getElementById('currentCode');

            let allCountries = [];

            // Open modal
            countrySelector.addEventListener('click', () => {
                countryModal.show();
                if (allCountries.length === 0) {
                    fetchCountries();
                }
            });

            // Fetch countries
            async function fetchCountries() {
                try {
                    const response = await fetch('https://restcountries.com/v3.1/all?fields=name,cca2,flags');
                    allCountries = await response.json();
                    renderCountries(allCountries);
                } catch (error) {
                    console.error('Error fetching countries:', error);
                    countryList.innerHTML = '<div class="text-danger p-3">Failed to load countries.</div>';
                }
            }

            // Render countries
            function renderCountries(countries) {
                countryList.innerHTML = countries.map(country => `
                                                                                                            <button class="list-group-item list-group-item-action d-flex align-items-center" 
                                                                                                                    onclick="selectCountry('${country.cca2}', '${country.flags.png}', '${country.name.common.replace(/'/g, "\\'")}')">
                                                                                                                <img src="${country.flags.png}" alt="${country.cca2}" width="30" class="me-3">
                                                                                                                <span>${country.name.common}</span>
                                                                                                            </button>
                                                                                                        `).join('');
            }

            // Search filter
            countrySearch.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                const filtered = allCountries.filter(c => c.name.common.toLowerCase().includes(term));
                renderCountries(filtered);
            });

            // Select country function (global scope for onclick)
            window.selectCountry = function (code, flagUrl, countryName) {
                currentFlag.src = flagUrl;
                currentCode.textContent = code;
                countryModal.hide();
                // Update the "Deliver to" location widget
                const deliverTo = document.getElementById('deliverToCountry');
                if (deliverTo && countryName) {
                    deliverTo.textContent = countryName;
                }
                // Save preference to localStorage
                localStorage.setItem('selectedCountry', JSON.stringify({ code, flagUrl, countryName }));
            };

            // Load saved preference
            const saved = localStorage.getItem('selectedCountry');
            if (saved) {
                const { code, flagUrl, countryName } = JSON.parse(saved);
                currentFlag.src = flagUrl;
                currentCode.textContent = code;
                // Also update "Deliver to" on page load
                const deliverTo = document.getElementById('deliverToCountry');
                if (deliverTo && countryName) {
                    deliverTo.textContent = countryName;
                }
            }
        });
    </script>
    <style>
        .search-result-item:hover {
            background-color: #f0f0f0 !important;
        }

        #searchResults::-webkit-scrollbar {
            width: 6px;
        }

        #searchResults::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }
    </style>
@endpush