@include('partials.loading')
@include('partials.header')
@include('partials.topbar')
@include('partials.navbar')

<!-- Main Content -->
<main class="py-4">
    @yield('content')
</main>

@include('partials.footer')
@include('partials.scripts')