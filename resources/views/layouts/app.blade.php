<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @include('partials.topbar')
        @include('partials.navbar')
        @include('partials.categories')

        <main class="py-4">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="wishlist-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Wishlist</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>

    @include('partials.scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wishlistButtons = document.querySelectorAll('.add-to-wishlist');
            const toastEl = document.getElementById('wishlist-toast');
            const toast = new bootstrap.Toast(toastEl);

            wishlistButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    const productId = this.dataset.productId;
                    const url = "{{ route('wishlist.add') }}";
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const toastBody = toastEl.querySelector('.toast-body');
                        toastBody.textContent = data.message;
                        toast.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
</body>
</html>
