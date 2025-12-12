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

    <!-- Sub-Navigation -->
    <div class="amz-subnav d-flex justify-content-center align-items-center"
        style="background: #232F3E; padding: 6px 0; border-top: 1px solid rgba(255,255,255,0.1);">
        <a href="{{ route('deals') }}" class="d-inline-flex align-items-center mx-4 text-decoration-none"
            style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 400; padding: 4px 0; border-bottom: 2px solid transparent; transition: all 0.2s;"
            onmouseover="this.style.borderBottomColor='#FF9900'; this.style.color='#fff';"
            onmouseout="this.style.borderBottomColor='transparent'; this.style.color='rgba(255,255,255,0.9)';">
            <i class="fas fa-bolt me-1" style="color: #FF9900; font-size: 12px;"></i>
            Today's Deals
        </a>
        <span style="color: rgba(255,255,255,0.3);">|</span>
        <a href="{{ route('wishlist.index') }}" class="d-inline-flex align-items-center mx-4 text-decoration-none"
            style="color: rgba(255,255,255,0.9); font-size: 13px; font-weight: 400; padding: 4px 0; border-bottom: 2px solid transparent; transition: all 0.2s;"
            onmouseover="this.style.borderBottomColor='#FF9900'; this.style.color='#fff';"
            onmouseout="this.style.borderBottomColor='transparent'; this.style.color='rgba(255,255,255,0.9)';">
            <i class="fas fa-heart me-1" style="color: #FF9900; font-size: 12px;"></i>
            Your Wishlist
            @if(count(session('wishlist', [])) > 0)
                <span class="ms-1"
                    style="background: #FF9900; color: #0F1111; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 10px;">
                    {{ count(session('wishlist', [])) }}
                </span>
            @endif
        </a>
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
                                                            <div class="p-3 text-muted text-center">
                                                                <i class="fas fa-search mb-2" style="font-size: 24px; opacity: 0.3;"></i>
                                                                <p class="mb-0">No products found for "<strong>${escapeHtml(query)}</strong>"</p>
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
                                                            <a href="/products/${product.slug}" class="search-result-item d-flex align-items-center p-2 text-decoration-none border-bottom" style="color: #333;">
                                                                <img src="${imageUrl}" alt="${escapeHtml(product.name)}" 
                                                                     style="width: 50px; height: 50px; object-fit: contain; margin-right: 12px; background: #f8f8f8; border-radius: 4px;">
                                                                <div class="flex-grow-1">
                                                                    <div class="fw-medium" style="font-size: 14px; line-height: 1.3;">${highlightMatch(product.name, query)}</div>
                                                                    <div style="color: #b12704; font-weight: 600; font-size: 13px;">${price}</div>
                                                                    ${product.category_name ? `<small class="text-muted">in ${escapeHtml(product.category_name)}</small>` : ''}
                                                                </div>
                                                            </a>
                                                        `;
                });

                // Add "View all results" link
                html += `
                                                        <a href="{{ route('products.search') }}?q=${encodeURIComponent(query)}&category=${searchCategory.value}" 
                                                           class="d-block p-3 text-center text-decoration-none" style="background: #f8f8f8; color: #007185; font-weight: 500;">
                                                            <i class="fas fa-search me-1"></i> View all results for "${escapeHtml(query)}"
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