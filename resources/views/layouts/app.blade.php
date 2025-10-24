@include('partials.header')
@include('partials.topbar')
@include('partials.navbar')
@include('partials.categories')

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

@include('partials.footer')
@include('partials.scripts')