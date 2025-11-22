{{-- Sci-Fi Loading Animation Component --}}
<div class="loading-overlay" id="loadingOverlay">
    <div class="sci-fi-loader">
        {{-- Rotating Rings --}}
        <div class="loader-ring loader-ring-1"></div>
        <div class="loader-ring loader-ring-2"></div>
        <div class="loader-ring loader-ring-3"></div>
        
        {{-- Pulsing Core --}}
        <div class="loader-core"></div>
        
        {{-- Floating Particles --}}
        <div class="loader-particle"></div>
        <div class="loader-particle"></div>
        <div class="loader-particle"></div>
        <div class="loader-particle"></div>
        <div class="loader-particle"></div>
        <div class="loader-particle"></div>
        <div class="loader-particle"></div>
        <div class="loader-particle"></div>
        
        {{-- Loading Text --}}
        <div class="loading-text">Loading</div>
    </div>
</div>

{{-- JavaScript to control loading overlay --}}
<script>
    // Show loading overlay
    function showLoading() {
        document.getElementById('loadingOverlay').classList.add('active');
    }
    
    // Hide loading overlay
    function hideLoading() {
        document.getElementById('loadingOverlay').classList.remove('active');
    }
    
    // Auto-hide loading on page load
    window.addEventListener('load', function() {
        hideLoading();
    });
    
    // Show loading on page unload (navigation)
    window.addEventListener('beforeunload', function() {
        showLoading();
    });
</script>
