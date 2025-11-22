<!-- Amazon-Style Header -->
<header class="amz-header">
    <!-- Top Bar -->
    <div class="amz-navbar-top">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="amz-logo-link">
            <span class="amz-logo-text">EEZEPC</span><span class="amz-logo-accent">.com</span>
        </a>

        <!-- Location Widget -->
        <div class="amz-location">
            <div class="amz-loc-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="amz-loc-text">
                <span class="amz-loc-line1">Deliver to</span>
                <span class="amz-loc-line2">Pakistan</span>
            </div>
        </div>

        <!-- Search Bar -->
        <form class="amz-search-form" action="{{ route('products.search') }}" method="GET">
            <div class="amz-search-group">
                <select class="amz-search-category">
                    <option value="all">All</option>
                    <option value="laptops">Laptops</option>
                    <option value="mobiles">Mobiles</option>
                </select>
                <input type="text" class="amz-search-input" name="query" placeholder="Search EEZEPC">
                <button type="submit" class="amz-search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <!-- Country Selector -->
        <div class="amz-country-selector" id="countrySelector">
            <img src="https://flagcdn.com/w20/us.png" alt="US" class="amz-flag-icon" id="currentFlag">
            <span class="amz-lang-code" id="currentCode">EN</span>
            <i class="fas fa-caret-down fa-xs ms-1 text-secondary"></i>
        </div>

        <!-- Account & Lists -->
        @auth
            <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('account') }}" class="amz-nav-item">
                <span class="amz-nav-line1">Hello, {{ auth()->user()->name }}</span>
                <span class="amz-nav-line2">Account & Lists</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="amz-nav-item">
                <span class="amz-nav-line1">Hello, sign in</span>
                <span class="amz-nav-line2">Account & Lists</span>
            </a>
        @endauth

        <!-- Returns & Orders -->
        <a href="#" class="amz-nav-item">
            <span class="amz-nav-line1">Returns</span>
            <span class="amz-nav-line2">& Orders</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('cart.view') }}" class="amz-cart-link">
            <div style="position: relative;">
                <i class="fas fa-shopping-cart fa-2x"></i>
                <span class="amz-cart-count">{{ count(session('cart', [])) }}</span>
            </div>
            <span class="amz-cart-text">Cart</span>
        </a>
    </div>

    <!-- Sub-Navigation -->
    <div class="amz-subnav">
        <a href="#" class="amz-subnav-link">
            <i class="fas fa-bars amz-menu-icon"></i> All
        </a>
        <a href="{{ route('deals') }}" class="amz-subnav-link">Today's Deals</a>
        <a href="#" class="amz-subnav-link">Customer Service</a>
        <a href="#" class="amz-subnav-link">Registry</a>
        <a href="#" class="amz-subnav-link">Gift Cards</a>
        <a href="#" class="amz-subnav-link">Sell</a>
    </div>
</header>

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
    document.addEventListener('DOMContentLoaded', function() {
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
                        onclick="selectCountry('${country.cca2}', '${country.flags.png}')">
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
        window.selectCountry = function(code, flagUrl) {
            currentFlag.src = flagUrl;
            currentCode.textContent = code;
            countryModal.hide();
            // Optional: Save preference to localStorage or cookie
            localStorage.setItem('selectedCountry', JSON.stringify({ code, flagUrl }));
        };

        // Load saved preference
        const saved = localStorage.getItem('selectedCountry');
        if (saved) {
            const { code, flagUrl } = JSON.parse(saved);
            currentFlag.src = flagUrl;
            currentCode.textContent = code;
        }
    });
</script>
@endpush
